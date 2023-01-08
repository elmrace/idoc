var axios = require("axios");

@if (count($route['bodyParameters']))
let data = JSON.stringify({
@foreach ($route['bodyParameters'] as $attribute => $parameter)
    "{{ $attribute }}": @if (in_array($parameter['type'], ['json', 'object'])){!! $parameter['value'] !!}@else"{{ $parameter['value'] }}"@endif,
@endforeach
});
@endif

var config = {
    method: "{{ $route['methods'][0] }}",
    url: "{{ rtrim(config('app.docs_url') ?: config('app.url'), '/') }}/{{ ltrim($route['uri'], '/') }}@if (count($route['queryParameters']))?@foreach ($route['queryParameters'] as $attribute => $parameter){{ $attribute }}={{ $parameter['value'] }}@endforeach @endif",
    headers = {
    @if (!array_key_exists('Accept', $route['headers']))
    "Accept": "application/json",
    @endif
    @if (!array_key_exists('Content-Type', $route['headers']))
"Content-Type": "application/json",
    @endif
    @foreach ($route['headers'] as $header => $value)
"{{ $header }}": "{{ $value }}",
    @endforeach},
    data: data
};

axios(config)
    .then(function (response) {
        console.log(JSON.stringify(response.data));
    })
    .catch(function (error) {
        console.log(error);
    });
