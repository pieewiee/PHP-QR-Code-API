<?php
    $dsn = "sqlsrv:server=$DBserver\sqlexpress;database=$DatabaseName";
    $conn = new PDO($dsn);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $totalValue = 0;
    $isfiltered = false;
   

    $includerows = array();
    $sqlColumns = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'" . $TableName . "'";
    foreach ($conn->query($sqlColumns) as $row) {
        array_push($includerows, $row[3]);
    }


    $sql = "SELECT Top 1 * from " . $TableName . ";";

    $rows = array();

    foreach ($conn->query($sql) as $row) {
    
            $columnSize = sizeof($row) / 2;
            $count = 0;
            foreach ($row as $key => $value) {
                if (!is_numeric($key))
                {
                    if (in_array($key, $includerows))
                    {

                        $count ++;
                        array_push($rows, $key);
                        
                    }
                                       
                }   
            }
            $rows = array_unique($rows);
    }
    $rows = array_values($rows);
    


    $sqltotal = "SELECT COUNT($PrimaryColumn) FROM " . $TableName . "";
    foreach ($conn->query($sqltotal) as $row) {
        $totalValue = $row[0];
        $isfilteredValue = $totalValue;
    }

    $sql = "SELECT " ;
    $sqlNofilter = "SELECT Count(*)" ;

    for ($i=0; $i < sizeof($rows); $i++) { 

        $columName = $rows[$i];


        $sql = $sql . '[' . $columName . ']' . ", ";
    }


    if(isset($_GET['headers']) && !empty($_GET['headers']))
    {    

        $sql = substr($sql, 0, -2);
        $sql = $sql . " FROM " . $TableName . ";";
        $sqlNofilter = $sqlNofilter . " FROM " . $TableName . ";";

        $headers = new stdClass();
        $count = 0;


        foreach ($rows as $key => $value) {
            $headers->{$value} = $key + 2;
            $count = $key;
        }
        
        $json[] = $headers;

            print json_encode($json); 
            exit;
    }
    else
    {

        $sql = substr($sql, 0, -2);
        $sql = $sql . " FROM " . $TableName . " ";
        $sqlNofilter = $sqlNofilter . " FROM " . $TableName . " ";

        if(isset($_GET['search']))
        {    
            $search = $_GET['search'];
            if(!$search == "")
            {
                try {
                
                    $isfiltered = true;
                    $sql = $sql . "Where (";
                    $sqlNofilter = $sqlNofilter . "Where (";
                    foreach ($rows as $key => $value) {
                        $columName = $value;

                        $sql = $sql . '[' . $columName .  "]" . " Like '%" . $search . "%'OR ";
                        $sqlNofilter = $sqlNofilter .  '[' . $columName . "]" . " Like '%" . $search . "%'OR ";
                    }
                    $sql = substr($sql, 0, -3);
                    $sqlNofilter = substr($sqlNofilter, 0, -3);
                    $sql = $sql . ") ";
                    $sqlNofilter = $sqlNofilter . ") ";
    
                } catch (\Throwable $th) {
                }
            }
        }


        if(isset($_GET['filter']))
        {    
            try {     
                
                $isfiltered = true;
                $filter = json_decode($_GET['filter']);
                $search = $_GET['search'];
                if (!isset($_GET['search']) || isset($_GET['search']) != "")
                {


                    if ($search == "")
                    {
                        $sql = $sql . "Where ";
                        $sqlNofilter = $sqlNofilter . "Where ";
                    }
                    elseif ($_GET['filter'] == "" )
                    {
                        $sql = $sql . "Where ";
                        $sqlNofilter = $sqlNofilter . "Where ";
                    }
                    else{

                        $sql = $sql . "And ";
                        $sqlNofilter = $sqlNofilter . "And ";
                    }




                    foreach ($filter as $key => $value) {
                        $columName = $key;


                        if ($value == "NOT NULL")
                        {
                            $sql = $sql . '[' . $columName . "]" . " <> '' AND ";
                            $sqlNofilter = $sqlNofilter . '[' . $columName . "]" . " <> '' AND ";
                        }
                        elseif ($value == "NULL")
                        {
                            $sql = $sql . '[' . $columName . "]" . " LIKE '' AND ";
                            $sqlNofilter = $sqlNofilter . '[' . $columName . "]" . " LIKE '' AND ";
                        }
                        elseif ($value == "DISTINCT")
                        {
                            $sql = $sql . " $PrimaryColumn IN (SELECT MAX($PrimaryColumn) FROM " . $TableName . " GROUP BY " . '[' . $columName . "]" . ") AND ";
                            $sqlNofilter = $sqlNofilter . " $PrimaryColumn IN (SELECT MAX($PrimaryColumn) FROM " . $TableName . " GROUP BY " . '[' . $columName . "]" . ") AND ";
                        }
                        elseif (startsWith($value, "!"))
                        {
                            $searchVal = ltrim($value, '!');
                            $sql = $sql . '[' . $columName . "]" . " NOT Like '%" . $searchVal . "%'AND ";
                            $sqlNofilter = $sqlNofilter . '[' . $columName . "]" . " NOT Like '%" . $searchVal . "%'AND ";
                        }
                        elseif (in_array($value, $WildCardExlude))
                        {
                            $sql = $sql . '[' . $columName . "]" . " = '" . $value . "'AND ";
                            $sqlNofilter = $sqlNofilter . '[' . $columName . "]" . " = '" . $value . "'AND ";
                        }
                        else
                        {
                            $sql = $sql . '[' . $columName . "]" . " Like '%" . $value . "%'AND ";
                            $sqlNofilter = $sqlNofilter . '[' . $columName . "]" . " Like '%" . $value . "%'AND ";
                        }
                    }
                    $sql = substr($sql, 0, -4);
                    $sqlNofilter = substr($sqlNofilter, 0, -4);
                    
                }
                else{
                    
                    $filter = json_decode($_GET['filter']);

                    $sql = $sql . "and ";
                    $sqlNofilter = $sqlNofilter . "and ";

                    

                    foreach ($filter as $key => $value) {
                        $columName = $key;

                        if ($value == "NOT NULL")
                        {
                            
                            $sql = $sql . '[' . $columName . "]" . " <> '' AND ";
                            $sqlNofilter = $sqlNofilter . '[' . $columName . "]" . " <> '' AND ";
                        }
                        elseif ($value == "NULL")
                        {
                            $sql = $sql . '[' . $columName . "]" . " LIKE '' AND ";
                            $sqlNofilter = $sqlNofilter . '[' . $columName . "]" . " LIKE '' AND ";
                        }
                        elseif ($value == "DISTINCT")
                        {
                            $sql = $sql . " $PrimaryColumn IN (SELECT MAX($PrimaryColumn) FROM " . $TableName . " GROUP BY " . "]" . $columName . "]" . ") AND ";
                            $sqlNofilter = $sqlNofilter . " $PrimaryColumn IN (SELECT MAX($PrimaryColumn) FROM " . $TableName . " GROUP BY " . "]" . $columName . "]" . ") AND ";
                        }
                        elseif (startsWith($value, "!"))
                        {
                            $searchVal = ltrim($value, '!');
                            $sql = $sql . '[' . $columName . '[' . " NOT Like '%" . $searchVal . "%'AND ";
                            $sqlNofilter = $sqlNofilter . '[' . $columName . "]" . " NOT Like '%" . $searchVal . "%'AND ";
                        }
                        elseif (in_array($value, $WildCardExlude))
                        {
                            $sql = $sql . '[' . $columName . '[' . " = '" . $value . "'AND ";
                            $sqlNofilter = $sqlNofilter . '[' . $columName . "]" . " = '" . $value . "'AND ";
                        }                        
                        else
                        {
                            $sql = $sql . '[' . $columName . '[' . " Like '%" . $value . "%'AND ";
                            $sqlNofilter = $sqlNofilter . '[' . $columName . "]" . " Like '%" . $value . "%'AND ";
                        }


                    }
                    $sql = substr($sql, 0, -4);
                    $sqlNofilter = substr($sqlNofilter, 0, -4);
                }
            } catch (\Throwable $th) {
            }
        }


        if (isset($_GET['sort']) && isset($_GET['order']))
        {
            $sort = $_GET['sort'];
            $order = $_GET['order'];
            
            $sql = $sql . " ORDER BY [" . $sort . "] " .  $order;

        }

        if (isset($_GET['offset']) && isset($_GET['limit']))
        {
            $offset = $_GET['offset'];
            $limit = $_GET['limit'];

            if (isset($_GET['sort']))
            {
                $sql = $sql . " OFFSET " . $offset . " ROWS FETCH NEXT " . $limit . " ROWS ONLY";
            }
            else{

                $sql = $sql . " ORDER BY $PrimaryColumn OFFSET " . $offset . " ROWS FETCH NEXT " . $limit . " ROWS ONLY";
            }  
        }

        $json = array();
        $response = new StdClass();
        if(isset($_GET['eexit']))
        {
            print $sql;
            print "<br></br>";
            print $sqlNofilter;
            exit;
        }
        
        $computers = array();
        foreach ($conn->query($sql) as $row) {
    
            $computer = new StdClass();
            $columnSize = sizeof($row) / 2;

            for ($i=0; $i < $columnSize; $i++) {
                if ($row[$i] != "")
                {
                    if (!empty($row[$i]))
                    {
                        $computer->{$rows[$i]} = $row[$i];
                    }
                } 
                
            }
            $computers[] = $computer;
    
        }

        if(count($computers) == 0)
        {
            $isfilteredValue = 0;
        }

        if ($isfiltered)
        {
                
            foreach ($conn->query($sqlNofilter) as $row) {
    
                $isfilteredValue = $row[0];
                break;
            }

        }

        $response->{"total"} = $isfilteredValue;
        $response->{"totalNotFiltered"} = $totalValue;
        $response->{"rows"} = $computers;

        
        print json_encode($response); 

        exit;
    }

function quoteString($string)
{
    $string = "'" . $string . "'";
    return $string;
}



function startsWith ($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

?>