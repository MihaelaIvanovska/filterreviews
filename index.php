<?php 
include 'ApiJson.php';

?>
<style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: sans-serif;
    }

    label {
        padding: 12px 12px 12px 0;
        display: inline-block;
    }

    select {
        width: 50%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
    }

    input[type=submit] {
        background-color: #2F54FF;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        float: left;
    }

    input[type=submit]:hover {
        background-color: #0F3CFF;
    }

    .container {
        border-radius: 5px;
        padding: 20px;
        margin-left: 100px;
    }

    .col-25 {
        float: left;
        width: 40%;
    }

    .col-75 {
        float: left;
        width: 75%;
        margin-top: 6px;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }
</style>

<div class="container">
    <form method="get">
        <h3 id="result">Filter reviews</h3>
        <div class="row">
            <div class="col-25">
                <label for="orderrate">Order by rating:</label>
            </div>
            <div class="col-75">
                <select id="raiting" name="nraiting">
                    <option value="HF">Highest First</option>
                    <option value="LF">Lowest First</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-25">
                <label for="minrate">Minimum rating</label>
            </div>
            <div class="col-75">
                <select id="minrating" name="minratingg">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="orderdate">Order by date:</label>
            </div>
            <div class="col-75">
                <select id="date" name="date">
                    <option value="NF">Newest First</option>
                    <option value="OF">Oldest First</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="prbytext">Prioritize by text:</label>
            </div>
            <div class="col-75">
                <select id="text" name="text">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>
        <div class="col-75">
            <input id='submit' type='submit' name='submit' value=Filter onclick='index.php?filterReviews=true'>
        </div>
    </form>

    <?php 
        $auth_header = 'Authorization: Bearer escfe7569d859dd903d77664e9983edf';
        $get_data = callAPI('GET', 'https://embedsocial.com/admin/v2/api/reviews?reviews_ref=0d44e0b0a245de6fc9651f870d8b44efc4653184', false, $auth_header);
        $response = json_decode($get_data, true);
        $errors = $response['response']['errors'];
        $data = $response['response']['data'][0];
//        var_dump($get_data);
        
        $list = $response['reviews'];
        $element = $list[0]['id'];
        echo $element;
        $timestamp=$list[0]['reviewCreatedOnTime'];
        echo gmdate("Y-m-d\TH:i:s\Z", $timestamp);
    function filterReviews(){
        $value = $_GET['nraiting']; 
            echo $value;
        $minRatingvalue = $_GET['minratingg']; 
            echo $minRatingvalue;
        $nameDateValue = $_GET['date']; 
            echo $nameDateValue;
        $nameTextValue = $_GET['text']; 
            echo $nameTextValue;
        $myFinalList = array();
        
        
        for($i=0; $i<sizeof($list); $i++){
            var_dump($list[$i]['id']);
            var_dump($list[$i]['reviewText']);

            $myFinalList[] = $list[i];
            if($nameTextValue == 'Yes'){
                if(!empty($list[i]['reviewText'])){
                    array_push($myFinalList, $list[i]);
                   // echo 'with text';
                }
            } else {
                array_push($myFinalList, $list[i]);
               // echo 'without text';
            }
            //sort Text By Priority
        
            if($minRatingvalue == '5'){
                if(!empty($list[i]['rating'])){
                    array_push($myFinalList, $list[i]);
                }
            } else if ($minRatingvalue == '4'){
                array_push($myFinalList, $list[i]);
            }
            else if ($minRatingvalue == '3'){
                array_push($myFinalList, $list[i]);
            }
            else if ($minRatingvalue == '2'){
                array_push($myFinalList, $list[i]);
            }
            else{
                array_push($myFinalList, $list[i]);
                }
            var_dump($myFinalList[i]);
            }
            if($nameDateValue == 'Oldest First'){
                array_push($myFinalList, $list[i]);
                usort($myFinalList, "sortNewestFirst");
                
            } else {
                 array_push($myFinalList, $list[i]);
                 usort($myFinalList, "sortNewestFirst");
            }
        
            $myFinalList = sortByReview();
            echo json_encode($myFinalList, true);
            echo $json_output;
        }
    
        function sortByReview(){
            usort($myFinalList, function($a, $b) {
            return $a['reviewText'] <=> $b['reviewText'];
            });
        }
        function sortNewestFirst($a1, $a2){
            if ($a1['reviewCreatedOnTime'] == $a2['reviewCreatedOnTime']) return 0;
            return ($a1['reviewCreatedOnTime'] > $a2['reviewCreatedOnTime']) ? -1 : 1;
        }
        usort($myFinalList, "sortNewestFirst");
    
        function sortOldestFirst($a1, $a2){
            if ($a1['reviewCreatedOnTime'] == $a2['reviewCreatedOnTime']) return 0;
            return ($a1['reviewCreatedOnTime'] < $a2['reviewCreatedOnTime']) ? -1 : 1;
        }
        usort($myFinalList, "sortOldestFirst");
   
        if(array_key_exists('submit', $_GET)) {
            filterReviews();
        }
       
       

  
             
    ?>




</div>