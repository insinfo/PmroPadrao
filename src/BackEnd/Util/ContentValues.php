<?php
/**
 * Created by PhpStorm.
 * User: Isaque
 * Date: 14/07/2017
 * Time: 22:07
 */

namespace PmroPadraoLib\Util;


class ContentValues
{
    private $values = array();
    private $query;
    private $tableName;
    private $conditions;
    private $cascade = false;

    /**
     * @return mixed
     */
    public function getCascade()
    {
        return $this->cascade;
    }

    /**
     * @param mixed $cascade
     */
    public function setCascade($cascade)
    {
        $this->cascade = $cascade;
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setWhereConditions($arrayAssocConditions)
    {
        $this->conditions = $arrayAssocConditions;
    }

    public function getWhereConditions()
    {
        return $this->conditions;
    }

    public function put($key, $value)
    {
        $string = null;
        if ($value == '')
        {
            $string = 'null';
        }
        else if ($value == null)
        {
            $string = 'null';
        }
        else
        {
            $string = "" . $value . "";
        }
        $this->values += [$key => $string];
    }

    public function getColumns()
    {
        $keys = array_keys($this->values);
        $columns = array();
        foreach ($keys as $val)
        {
            $columns[] = '"' . $val . '"';
        }
        return implode(", ", $columns);
    }

    public function getValues(\PDO $pdo)
    {
        $sql = "";
        foreach ($this->values as $val) {
            //adding value
            if ($val === NULL || $val === 'null')
                $sql .= "NULL";
            else
                /*
                useless piece of code see comments
                if($val === FALSE)
                   $sql .= "FALSE";
                else
                */
                $sql .= "" . $pdo->quote($val) . "";

            $sql .= ", ";
        };

        return " " . rtrim($sql, " ,") . " ";
    }

    public function getUpdateString(\PDO $pdo)
    {
        $result = "";
        $keys = array_keys($this->values);
        $i = 0;
        foreach ($this->values as $val)
        {
            if ($val === NULL || $val === 'null') {
                $sqlVal = "NULL";
            }
            else
            {
                $sqlVal = $pdo->quote($val);
            }

            $result .= ' "' . $keys[$i] . '" ' . "=" . $sqlVal . ' ';
            $result .= ", ";
            $i++;
        }
        return " " . rtrim($result, " ,") . " ";
    }

    public function addQuery($query)
    {
        $this->query = $query;
    }

    public function bindTable($search, $replace)
    {
        $this->query = str_replace($search, $replace, $this->query);
    }

    public function bindColumn($search, $replace)
    {
        $this->query = str_replace($search, $replace, $this->query);
    }

    public function bindValue($search, $replace)
    {
        $this->query = str_replace($search, "'" . $replace . "'", $this->query);
    }

    public function getQuery()
    {
        return $this->query;
    }


}