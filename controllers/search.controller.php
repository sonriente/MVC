<?php

class SearchController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Searching();
    }

    public function index()
    {
        if ($_GET) {
            $query = isset($_GET['query']) ? $_GET['query'] : null;
            $param = $_GET['param'];
            $query = trim(htmlspecialchars($query));
            if (!empty($query)) {
                $this->data['films'] = $this->model->searchByTitle($query, $param);
                $count = count($this->data['films']);
                if ($count) {
                    Session::setFlash("On Your Request {$count} Matches Found");
                }
            } else {
                Session::setFlash("Empty Your Search Query");
            }
        }
    }

    public function admin_index()
    {
        if ($_GET) {
            $query = isset($_GET['query']) ? $_GET['query'] : null;
            $param = $_GET['param'];
            $query = trim(htmlspecialchars($query));
            if (!empty($query)) {
                $this->data['films'] = $this->model->searchByTitle($query, $param);
                $count = count($this->data['films']);
                if ($count) {
                    Session::setFlash("On Your Request {$count} Matches Found");
                } else {
                    Session::setFlash("On Your Request {$count} Matches Found");
                }
            } else {
                Session::setFlash("Empty Your Search Query");
            }
        }
    }

}



