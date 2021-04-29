<?php

namespace App\Http\Controllers\Data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\System\Response;

class Get extends Controller
{
    function get()
    {
          $arr=[
                "employers"=>app("\App\Http\Controllers\Users\Search")->get([
                  "filter"=>[
                    "role"=>2
                  ]
                ])["value"],
                "category"=>app("\App\Http\Controllers\Vacancy\Category\Search")->get()["value"],
                "city"=>app("\App\Http\Controllers\Geography\City\Search")->get()["value"],
                "visa"=>[
                ["id"=>0,"name"=>"Біометрія"],
                ["id"=>1,"name"=>"Віза"],
                ["id"=>2,"name"=>"Будь-яка"]
               ],
                "sex"=>[
                "0"=>["id"=>0,"name"=>"Чоловіча"],
                "1"=>["id"=>1,"name"=>"Жіноча"],
                "2"=>["id"=>2,"name"=>"Обидві"],
                "3"=>["id"=>3,"name"=>"Пари"]
                ],
                "changes"=>[
                ["id"=>0,"name"=>"Нічна"],
                ["id"=>1,"name"=>"Денна"],
                ["id"=>2,"name"=>"Обидві"]
               ],
                "season"=>[
                ["id"=>0,"name"=>"Всезоність"],
                ["id"=>1,"name"=>"Зима"],
                ["id"=>2,"name"=>"Весна"],
                ["id"=>3,"name"=>"Літо"],
                ["id"=>4,"name"=>"Осінь"]
               ],
                "urgently"=>[
                ["id"=>0,"name"=>"Не терміново"],
                ["id"=>1,"name"=>"Терміново"]
               ],
               "paymentPeriod"=>[
               "0"=>["id"=>0,"name"=>"Година"],
               "1"=>["id"=>1,"name"=>"Тиждень"],
               "2"=>["id"=>2,"name"=>"Місяць"]
               ],
               "skillLanguage"=>[
                ["id"=>0,"name"=>"Не потрібно"],
                ["id"=>1,"name"=>"Потрібно"]
               ],
               "bonus"=>[
                ["id"=>0,"name"=>"Не має"],
                ["id"=>1,"name"=>"Є"]
               ],
               "food"=>[
               ["id"=>0,"name"=>"Не включенно"],
               ["id"=>1,"name"=>"Включенно"]
               ],
               "house"=>[
               ["id"=>0,"name"=>"Не включенно"],
               ["id"=>1,"name"=>"Включенно"]
               ]
              ];

         return Response::get(200,count($arr),$arr);
    }
    public function users()
    {
     $arr=[
       "roles"=>[
         ["id"=>2,"name"=>"Роботодавець"],
         ["id"=>3,"name"=>"Водій"],
         ["id"=>4,"name"=>"Редактор"],
         ["id"=>6,"name"=>"Адміністратор"]
       ],
       "city"=>app("\App\Http\Controllers\Geography\City\Search")->get()["value"],
     ];
     return Response::get(200,count($arr),$arr);
    }
    public function applications()
    {
     $arr=[
      "status"=>[
       ["id"=>0,"name"=>"Нова"],
       ["id"=>1,"name"=>"Відхилена"],
       ["id"=>2,"name"=>"Прийнята"]
      ],
      "vacancy"=>app("\App\Http\Controllers\Vacancy\Search")->get()["value"],
      "clients"=>app("\App\Http\Controllers\Clients\Search")->get()["value"]
     ];
     return Response::get(200,count($arr),$arr);
    }
    public function transport()
    {
     $arr=[
      "type"=>[
       ["id"=>0,"name"=>"Бус"],
       ["id"=>1,"name"=>"Автобус"],
       ["id"=>2,"name"=>"Легкова"]
      ]
     ];
     return Response::get(200,count($arr),$arr);
     }
     public function trips()
     {
      $arr=[
       "transport"=>app("\App\Http\Controllers\Transports\Search")->get()["value"],
       "drivers"=>app("\App\Http\Controllers\Users\Search")->get(["filter"=>["role"=>3]])["value"],
       "routes"=>app("\App\Http\Controllers\Routes\Search")->get()["value"]
      ];
     return Response::get(200,count($arr),$arr);
    }
    public function tickets()
    {
     $arr=[
       'clients'=>app("\App\Http\Controllers\Clients\Search")->get()["value"],
       'transports'=>app("\App\Http\Controllers\Transports\Search")->get()["value"],
       'routes'=>app("\App\Http\Controllers\Routes\Children\Search")->get()["value"],
       'trip'=>app("\App\Http\Controllers\Trips\Search")->get()["value"],
       'city'=>app("\App\Http\Controllers\Geography\City\Search")->get()["value"],
       'cityFrom'=>app("\App\Http\Controllers\Geography\City\Search")->get()["value"],
       'cityTo'=>app("\App\Http\Controllers\Geography\City\Search")->get()["value"],
       'currency'=>\App\Models\Data\Currency::get(),
       'typePayment'=>\App\Models\Data\TypePayment::get()
     ];
     return Response::get(200,count($arr),$arr);
    }
    public function routes()
    {
     $arr=[
       'city'=>app("\App\Http\Controllers\Geography\City\Search")->get()["value"]
     ];
     return Response::get(200,count($arr),$arr);
    }
    public function route()
    {
     $arr=[
       'city'=>app("\App\Http\Controllers\Geography\City\Search")->get()["value"],
       'routes'=>app("\App\Http\Controllers\Routes\Search")->get()["value"]
     ];
     return Response::get(200,count($arr),$arr);
    }
    public function city()
    {
     $arr=[
       'type'=>[
        ['id'=>0,'name'=>'Село'],
        ['id'=>1,'name'=>'Місто'],
       ],
       'region'=>app("\App\Http\Controllers\Geography\Region\Search")->get()["value"],
       'country'=>app("\App\Http\Controllers\Geography\Country\Search")->get()["value"],
     ];
     return Response::get(200,count($arr),$arr);
    }
    public function region()
    {
     $arr=[
       'country'=>app("\App\Http\Controllers\Geography\Country\Search")->get()["value"]
     ];
     return Response::get(200,count($arr),$arr);
    }
}
