<x-mail::message>

{{$name}} Email Template

<x-mail::table>
| Film Title    |  User         | Example  |
| ------------- |:-------------:| --------:|
| Test Film     | Jerry         | $10      |
</x-mail::table>

<x-mail::button :url="$url" color="success">
View Image
</x-mail::button>

</x-mail::message>