<?php

class TemplateController extends Controller
{

    // HOW TO - Access URL parameters
    // --- $this->getUrlParam('userId')
    // for this url: '/users/123', this function would return '123' for the respective route: '/users/userId'

    // HOW TO - Check for GET Parameters
    // --- validateInputs(array $inputs)
    // NB: the callback does not need to be specified

    // HOW TO - Throw an error
    // --- throwError(400, 'bad request')

    // HOW TO - Throw a reponse
    // --- sendResponse(200, myObject)

    // HOW TO - Throw a reponse of MYSQL statement
    // --- $stmt = $this->db->prepare("SELECT * FROM `ww` WHERE 1 ORDER BY `name` ASC");
    // --- $this->response($stmt);

    // Find all functions available in the controller class

    // supported functions are GET/POST/PUT/DELETE

    public function GET()
    {
        sendResponse(200, 'ok');
    }
}
