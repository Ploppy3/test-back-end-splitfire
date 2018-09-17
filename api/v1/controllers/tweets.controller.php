<?php

class TweetsController extends Controller
{

    public function GET()
    {
        /*
        author (string) : Récupérer la liste des événements associés à cet utilisateur (optionnel)
        hashtag (string) : Récupérer la liste des événements associés au tag "hashtag" (optionnel)
        page (int) : Page de résultat à récupérer (requis, valeur par défaut : 1)
        count (int) : Nombre de résultats par page souhaité (requis, valeur par défaut : 25)
        //*/

        if (isset($_GET['page']) && isset($_GET['count'])) {
            $page = intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
            $count = intval($_GET['count']) > 0 ? intval($_GET['count']) : 25;

            $conditionFilterByUser = isset($_GET['author']) ? "WHERE tweet.user = '{$_GET['author']}'" : null;
            $conditionFilterByHashtag = isset($_GET['hashtag']) ? "HAVING hashtags REGEXP '(^|,){$_GET['hashtag']}(,|$)'" : null;

            $stmt_fetchTweets = $this->db->prepare(
                "SELECT tweet.id, tweet.user, tweet.message, tweet.date, GROUP_CONCAT(hashtag) AS hashtags
                FROM `tweets`
                AS tweet
                LEFT JOIN (SELECT * FROM `hashtags`) AS hashtag
                ON tweet.id = hashtag.idTweet
                $conditionFilterByUser
                GROUP BY id
                $conditionFilterByHashtag
                LIMIT :limit
                OFFSET :offset"
            );
            $stmt_fetchTweets->bindValue(":limit", $count, PDO::PARAM_INT);
            $stmt_fetchTweets->bindValue(":offset", ($page - 1) * $count, PDO::PARAM_INT);

            if ($stmt_fetchTweets->execute()) {
                $tweets = $stmt_fetchTweets->fetchAll(PDO::FETCH_ASSOC);
                foreach ($tweets as &$tweet) {
                    $tweet['id'] = intval($tweet['id']);
                    $tweet['hashtags'] = ($tweet['hashtags'] === null) ? array() : explode(',', $tweet['hashtags']);
                    $date = new DateTime($tweet['date']);
                    $tweet['date'] = $date->format('d/m/Y H:i:s');
                }
                sendResponse(200, $tweets);
            } else {
                throwError(500, "impossible de récupérer les tweets");
            }
        } else {
            throwError(400, '[page, count] sont des champs requis');
        }
    }

    public function POST()
    {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON);

        if (json_last_error() === JSON_ERROR_NONE) {
            if (isset($input->author) && isset($input->message)) { // check required fields
                $user = $input->author;
                $message = $input->message;
                if (strlen($message) < 1000) { // check message max length
                    $currentDateTime = new DateTime();
                    $stmt_insertTweet = $this->db->prepare("INSERT INTO `tweets`(`id`, `user`, `date`, `message`) VALUES (default, :user, :date, :message)");
                    $stmt_insertTweet->bindValue(":user", $user);
                    $stmt_insertTweet->bindValue(":date", $currentDateTime->format('Y-m-d H:i:s'));
                    $stmt_insertTweet->bindValue(":message", $message);
                    if ($stmt_insertTweet->execute()) {
                        $idTweet = $this->db->lastInsertId();
                        if (isset($input->hashtags)) {
                            if (gettype($input->hashtags) === 'array') {
                                $this->insertHashtags($input->hashtags, $idTweet);
                            } else {
                                throwError(400, '[hashtags] doit être de type array');
                            }
                        }
                        sendResponse(201, $idTweet); // return tweet id
                    } else {
                        throwError(500, 'impossible de sauvegarder le tweet');
                    }
                } else {
                    throwError(400, '[message] ne doit pas excéder 1000 caractères');
                }
            } else {
                throwError(400, '[author, message] sont des champs requis');
            }
        } else {
            throwError(400, 'le body de la requête doit être sous le format JSON');
        }
    }

    /** [hashtags] is an array of string */
    private function insertHashtags($hashtags, $idTweet)
    {
        foreach ($hashtags as $hashtag) {
            $stmt_insertHashtag = $this->db->prepare("INSERT INTO `hashtags`(`idTweet`, `hashtag`) VALUES (:idTweet, :hashtag)");
            $stmt_insertHashtag->bindValue(":idTweet", $idTweet);
            $stmt_insertHashtag->bindValue(":hashtag", $hashtag);
            if ($stmt_insertHashtag->execute() === false) {
                throwError(500, 'impossible de sauvegarder le tweet');
            }
        }
    }
}
