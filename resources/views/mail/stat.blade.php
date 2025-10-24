<x-mail::message>
# Introduction


Количество добалвенных комментариев: {{$countComments}}

Количество просмотренных статей: {{$countArticle[0]['count']}}

Просмотрены следующие статьи: 

@foreach($countArticle as $value)

        {{$value['article_title']}}
        
@endforeach

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
