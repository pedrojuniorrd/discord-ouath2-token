<?php
require __DIR__ . '/vendor/autoload.php';

use \Curl\Curl;

$conf = new \stdClass();
$curl = new Curl();
$curl->setHeader('Content-Type', 'application/x-www-form-urlencoded');



function get_api_token($conection){
    $response_get = $conection->post(
        'https://discord.com/api/oauth2/token',
        array(
                'grant_type' => 'authorization_code',
                'client_id' => '{BOT CLIENT ID}',
                'client_secret' => '{BOT CLIENT SECRET}',
                'redirect_uri' => '{REDIRECT URL CADASTRADA NO DISCORD}',
                'code' => $_GET["code"],
                'scope' => 'identify email guilds'
            )
    );

    $response_get = json_decode(json_encode($conection->response->access_token),true);
    print_r("api key token :".$response_get);
    get_current_user_data($response_get);
}

function get_current_user_data($token){
    
    $curl_data = new Curl();
    $curl_data->setHeader('Authorization', 'Bearer '.$token);
    
    $response_data = $curl_data->get(
        #'https://discord.com/api/v8/guilds/{GUILD ID}/members/'.$token
        #'https://discord.com/api/v8/users/@me/guilds'
        'https://discord.com/api/v8/users/@me'
    );
    $response3 = json_decode(json_encode($response_data->id),true);

    echo '<pre>';
    print_r("USER ID:".$response3);
    get_current_user_guild_data($response3);
    #echo '<pre>';
    #print_r ($curl_data->requestHeaders);
}


function get_current_user_guild_data($user){
    
    $curl_data = new Curl();
    $curl_data->setHeader('Authorization', 'Bot '.'{PUBLIC BOT KEY}');
    
    $response_data = $curl_data->get(
        'https://discord.com/api/v8/guilds/{GUILD ID}/members/'.$user
        #'https://discord.com/api/v8/users/@me/guilds'
        #'https://discord.com/api/v8/users/@me'
    );
    $response4 = json_decode(json_encode($response_data->roles),true);
    print_r($response4);
    if (in_array("{ID DE CARGO}",$response4)){
        print ("o usuário tem o cargo");
    }else{
        print ("o usuário não tem o cargo");
    }

}


function get_client_token($conection2){
    
    $response_get2 = $conection2->post(
        'https://discord.com/api/v8/oauth2/token',
        array(
            'grant_type' => 'client_credentials',
            'scope' => 'identify guilds email',
            'client_id' => '{CLIENT ID}',
            'client_secret' => '{CLIENT SECRET}'

         )
    );

    
    $response_get2 = json_decode(json_encode($conection2->response),true);
    print_r ($response_get2);
    #print_r ($response_get2);
    #get_user_data($response_get2);
}



get_api_token($curl);
#get_client_token($curl);

