<?php

class FilmsController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Film();
    }

    public function index()
    {
        $this->data['films'] = $this->model->getList();

        if ($_GET) {
            $sort = htmlspecialchars($_GET['sort']);
            if ($sort == 'asc' || $sort == 'desc') {
                $this->data['films'] = $this->model->sortByTitle($sort);
            } else {
                $this->data['films'] = $this->model->getList();
            }
        }

    }

    public function view()
    {
        $params = App::getRouter()->getParams();

        if (isset($params[0])) {
            $id = strtolower($params[0]);
            $this->data['film'] = $this->model->getById($id);
        }
    }

    public function admin_index()
    {
        $this->data['films'] = $this->model->getList();

        if ($_GET) {
            $sort = htmlspecialchars($_GET['sort']);
            if ($sort == 'asc' || $sort == 'desc') {
                $this->data['films'] = $this->model->sortByTitle($sort);
            } else {
                $this->data['films'] = $this->model->getList();
            }
        }

    }

    public function admin_view()
    {
        $params = App::getRouter()->getParams();

        if (isset($params[0])) {
            $id = strtolower($params[0]);
            $this->data['film'] = $this->model->getById($id);
        }
    }

    public function admin_add()
    {
        $this->data['formats'] = $this->model->getFormats();

        if ($_POST) {
            $result = $this->model->save($_POST);
            if (!$result) {
                Session::setFlash("Error");
            }
            Router::redirect('/admin/films/');
        }
    }

    public function admin_addfromfile()
    {
        if ($_FILES) {
            $fileName = $_FILES['file']['name'];
            $uploadFile = "./uploads/{$fileName}";
            if (copy($_FILES['file']['tmp_name'], $uploadFile)) {
                Session::setFlash("File {$fileName} was loaded successfully");
            } else {
                Session::setFlash("Error! File {$fileName} wasn't loaded");
                exit;
            }
            $lines = file($uploadFile);
            foreach ($lines as $key => $line) {
                if (strlen($line) <= 1) {
                    unset($lines[$key]);
                }
            }
            $count = count($lines);
            reset($lines);
            for ($i = 0; $i < $count;) {
                if (current($lines)) {
                    $data['title'] = trim(str_replace('Title:', '', current($lines)));
                    array_shift($lines);
                }
                if (current($lines)) {
                    $data['year'] = trim(str_replace('Release Year: ', '', current($lines)));
                    array_shift($lines);
                }
                if (current($lines)) {
                    $data['format'] = trim(str_replace('Format: ', '', current($lines)));
                    array_shift($lines);
                }
                if (current($lines)) {
                    $data['actors'] = trim(str_replace('Stars: ', '', current($lines)));
                    array_shift($lines);
                }
                if ($data) {
                    $result = $this->model->saveFromFile($data);
                    if (!$result) {
                        Session::setFlash("Error");
                    }
                    Router::redirect('/admin/films/');
                }
                $i = $i + 4;
            }
        }
    }

    public function admin_edit()
    {
        $this->data['formats'] = $this->model->getFormats();

        if ($_POST) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if (!$result) {
                Session::setFlash("Error");
            }
            Router::redirect('/admin/films/');
        }

        if (isset($this->params[0])) {
            $this->data['film'] = $this->model->getById($this->params[0]);
        } else {
            Session::setFlash('Wrong Film Id');
            Router::redirect('/admin/films/');
        }
    }

    public function admin_delete()
    {
        if (isset($this->params[0])) {
            $result = $this->model->delete($this->params[0]);
            if (!$result) {
                Session::setFlash("Error");
            }
            Router::redirect('/admin/films/');
        }
    }

}