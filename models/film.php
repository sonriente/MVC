<?php

class Film
{
    public function getList()
    {
        $db = DB::getInstance()->getPDO();
        $sql = 'SELECT films.id, films.title, films.year, format.name as format, films.actors
                FROM films JOIN format ON films.format = format.id
                GROUP BY films.id';
        $sth = $db->query($sql);
        $sth->execute();
        $filmList = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $filmList;
    }

    public function getById($id)
    {
        $db = DB::getInstance()->getPDO();
        $sql = 'SELECT films.id, films.title, films.year, format.name as format, films.actors
                FROM films JOIN format ON films.format = format.id
                WHERE films.id = :id
                GROUP BY films.id';
        $sth = $db->prepare($sql);
        $params = array(
            'id' => $id,
        );
        $sth->execute($params);
        $film = $sth->fetch(PDO::FETCH_ASSOC);
        if (!$film) {
            throw new Exception('Film not found', 404);
        }
        return $film;
    }

    public function getFormats()
    {
        $db = DB::getInstance()->getPDO();
        $sql = 'SELECT id, name FROM format';
        $sth = $db->query($sql);
        $sth->execute();
        $formats = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $formats;
    }

    public function save($data, $id = null)
    {
        if (!isset($data['title']) || !isset($data['year']) || !isset($data['format']) || !isset($data['actors'])) {
            return false;
        }
        $db = DB::getInstance()->getPDO();
        if (!$id) {
            $sql = "INSERT INTO films (title, year, format, actors)
                    VALUES (:title, :year, :format, :actors)";
        } else {
            $sql = "UPDATE films
                    SET title = :title,
                        year = :year,
                        format = :format,
                        actors = :actors
                    WHERE id = :id";
        }
        $sth = $db->prepare($sql);
        $result = $sth->execute($data);
        return $result;
    }

    public function saveFromFile($data)
    {
        $db = DB::getInstance()->getPDO();
        $sql = 'INSERT INTO films (title, year, format, actors)
                VALUES (:title, :year, (SELECT id FROM format WHERE name = :format), :actors);';
        $sth = $db->prepare($sql);
        $result = $sth->execute($data);
        return $result;
    }

    public function delete($id)
    {
        $db = DB::getInstance()->getPDO();
        $sql = "DELETE FROM films WHERE id = :id";
        $sth = $db->prepare($sql);
        $params = array(
            'id' => $id,
        );
        $result = $sth->execute($params);
        return $result;
    }

    public function sortByTitle($sort)
    {
        $db = DB::getInstance()->getPDO();
        $sql = "SELECT films.id, films.title, films.year, format.name as format, films.actors
                FROM films JOIN format ON films.format = format.id
                GROUP BY films.id";
        if ($sort == 'asc') {
            $sql .= " ORDER BY films.title";
        } else {
            $sql .= " ORDER BY films.title DESC";
        }
        $sth = $db->query($sql);
        $sth->execute();
        $filmList = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $filmList;
    }

}