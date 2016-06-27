<?php

namespace TestProject\Controller\Location;

class County extends \TestProject\Controller\BaseController
{
    public function __construct($app)
    {
        $this->connect = $app['connect'];
    }

    public function homeAction()
    {
        return $this->render(['countylist' => $this->getCountyList()]);
    }

    public function getCountyList()
    {
        $counties = array();
        $requestCountyList = \ORM::for_table('county')
            ->find_many();
        foreach ($requestCountyList as $county) {
            $counties [] = array('id' => $county['id'], 'name' => $county['name']);
        }

        return $counties;
    }

    public function getCounty($id)
    {
        $sqlRequest = \ORM::for_table('county')
            ->where('id', $id)
            ->find_many();
        foreach ($sqlRequest as $element) {
            $county [] = array('id' => $element['id'], 'name' => $element['name']);
        }

        return $county;
    }

    public function addCountyAction($request)
    {
        if ($request->getMethod() === 'POST') {
            $county = $request->get('county');
        // TEST FIELDS FOR NON-EMPTY AND LENGTH
         if (!$county) {
             echo '<script language="javascript">alert("County filed can not be empty.")</script>';
         } else {
             // REFACTOR INSERT QUERIES
             $checkCounty = \ORM::for_table('county')
                ->where('name', $county)
                ->find_one();
             if ($checkCounty) {
                 foreach ($checkCounty as $county) {
                     $countyId = $county['id'];
                 }
                 echo "<script>alert('County already exists in DB.')</script>";
             } else {
                 $addNewCounty = \ORM::for_table('county')->create();
                 $addNewCounty->set('name', $request->get('county'))->save();
                 echo "<script>window.location.href='/home2'</script>";

                 $countyId = $addNewCounty->id;
             }
         }
        }//end of POST method check
    return $this->render(['counties' => $this->getCountyList()]);
    }

    public function editCountyAction($request)
    {
        $id = $request->get('id');
        if ($request->getMethod() == 'GET') {
            return $this->render(['county' => $this->getCounty($id)]);
        } else {
            $countyid = $request->get('countyid');
            $name = $request->get('name');
            $sqlUpdate = 'UPDATE county SET name="'.$name.'"WHERE id='.$id;
            if ($this->connect->query($sqlUpdate) === true) {
                echo "<script>
                 alert('County successfully updated.');
                 window.location.href='/home2';
                 </script>";
            } else {
                echo 'Error updating record: '.$this->connect->error;
                exit();
            }
        }
    }

    public function deleteCountyAction($request)
    {
        $id = $request->get('id');
        $county = \ORM::for_table('county')
            ->where('id', $id)
            ->find_one();
        $cities = \ORM::for_table('city')
            ->where('county_id', $id)
            ->find_one();
        if ($cities['id']) {
            echo "<script>
 alert('That county can not be deteled. Only empty (without registred cities) counties can be deleted.');
 window.location.href='/home2';
 </script>";
        } else {
            $deleteQuery = \ORM::for_table('county')
                ->where('id', $id)
                ->delete_many();
            echo "<script>
 alert('County deleted.');
 window.location.href='/home2';
 </script>";
        }

        return $this->render(['id' => $county['id'], 'countyName' => $county['name']]);
    }

    public function searchLocationAction($request)
    {
        if (!isset($_SESSION['location_search'])) {
            $_SESSION['location_search'] = array();
        }
        $locations = $_SESSION['location_search'];
        $searchField = $request->get('userSearch', @$locations['searchField']);
        $category = $request->get('SearchBy', @$locations['category']);

        if ($request->getMethod() == 'POST') {
            $locations['searchField'] = $request->get('userSearch');
            if ($request->get('SearchBy') == 'County') {
                $locations['category'] = 'county';
            } else {
                $locations['category'] = 'city';
            }
            $_SESSION['location_search'] = $locations;
        }

        return $this->searchHelp($searchField, $category);
    }

    public function searchHelp($searchTerm, $category)
    {
        $countiesAndCities = [];
        $baseQuery = \ORM::for_table('county')
            ->join('city', 'county.id = city.county_id')
            ->order_by_asc('county.name')
            ->select('county.name', 'county')
            ->select('city.name', 'city');

        if (!empty($searchTerm) && !is_null($category)) {
            $baseQuery->where("$category.name", $searchTerm);
        }
        $results = $baseQuery->find_many();
        if (!$results) {
            echo 'No result was found.';
        }
        foreach ($results as $row) {
            $countiesAndCities [] = $row;
        }

        return $this->render(['countiesAndCities' => $countiesAndCities, 'searchTerm' => $searchTerm,  'category' => $category]);
    }
}//end of countyList class
;
