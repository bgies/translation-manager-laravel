@extends((Request::ajax())?'translationeditor::blanklayout':'translationeditor::layout')

@section('content')

         @foreach($filearray as $index => $single)
            <tr>
               <td align="right" style="padding: 12px 5px 0px 0px"><strong>{!! $index !!}</strong></td>
               <td><input style="margin: 2px 0; width: 100%" type="text" name="{!! $language . '-' . $index !!}" value="{!! print_r($single, true) !!}" /></td>
               <td><input style="margin: 2px 0; width: 100%" type="text name="compare-{!! $index !!}" value=""></td>
            </tr>
         @endforeach


@stop