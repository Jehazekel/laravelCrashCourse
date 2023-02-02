

{{-- Rndering children tags using '$slot' --}}


{{-- to combine external class & internal class --}}
<div {{$attributes->merge(
  ['class' => 'bg-gray-50 border border-gray-200 rounded p-6']
)}}> 
  {{-- class is merge with our internal default class --}}



  {{$slot}}

</div>