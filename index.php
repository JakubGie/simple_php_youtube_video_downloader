<?php

    include('simple_html_dom.php');


    // Set those three variables only

    $youtube_video_id = "nFZP8zQ5kzk";

    $api_key = "be532afb54msh1c0bc087509b2cbp159e39jsn3ae2f098ec45"; // Go to rapidapi.com and register to get your unique api key and aply for YTStream - Download YouTube Videos api (its free until you want to make over 200 requests a day)

    $file_name = 'example.mp4'; // Set a route where you want to save your video file. In this case, we saving in the same directory




    // Here goes magic ;)

    $base = "https://ytstream-download-youtube-videos.p.rapidapi.com/dl?id=".$youtube_video_id;

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $base,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: ytstream-download-youtube-videos.p.rapidapi.com",
            "X-RapidAPI-Key:  $api_key"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    $html_base = new simple_html_dom();

    $html_base->load($response);

    $response_data = json_decode($html_base);


    if($err) {
        echo "cURL Error:" . $err;
    } else {
        $which = 1;
        foreach ($response_data->formats as $single) {
            if($which==3) {
                if(file_put_contents($file_name, file_get_contents($single->url)))
                {
                    echo '<b>Youtube video downloaded successfully</b>';
                }
                else
                {
                    echo '<b>Some error occurred</b>';
                }

                break;
            }
            
            $which++;
        }
    }

?>