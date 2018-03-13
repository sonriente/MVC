<?php

class Searching
{
    public function searchByTitle($query, $param)
    {
        $db = DB::getInstance()->getPDO();
        $sql = "SELECT films.id, films.title, films.year, format.name as format, films.actors
                FROM films JOIN format ON films.format = format.id WHERE 1";
        if ($param == 'title') {
            $sql .= " AND films.title LIKE :query";
        } else {
            $sql .= " AND films.actors LIKE :query";
        }
        $sql .= " ORDER BY films.id";
        $sth = $db->prepare($sql);
        $params = array(
            'query' => '%' . $query . '%',
        );
        $sth->execute($params);
        $films = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $films;
    }
}