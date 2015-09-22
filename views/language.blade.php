         @foreach($language1 as $index => $single)
            <tr>
               <td align="right" style="padding: 12px 5px 0px 0px"><strong>{!! $index !!}</strong></td>
               <td>
                  @if (is_array($single))
                     <textarea rows="4" cols="60" name="{!! $locale1 . '-' . $index !!}" >{!! print_r($single, true) !!}</textarea>
                  @else
                     <input style="margin: 2px 0; width: 80%" type="text" name="{!! $locale1 . '-' . $index !!}" value="{!! print_r($single, true) !!}" />
                  @endif
                  <button data-input="{!! $locale1 . '-' . $index !!}" data-original-value="{!! print_r($single, true) !!}" type="submit" class="btn btn-primary btn-sm save-string" title="Save"><span class="glyphicon glyphicon-save icon-white"></span><span class="sr-only">Save Default String</span></button>
               <td><span>
                  @if (is_array($single))
                     <textarea rows="4" cols="60" name="{!! $locale2 . '-' . $index !!}" >@if (array_key_exists($index, $language2)){!! print_r($language2[$index], true) !!}@endif</textarea>
                  @else
                     <input style="margin: 2px 0; width: 80%" type="text" name="{!! $locale2 . '-' . $index !!}" 
                        value="@if (array_key_exists($index, $language2)){!! print_r($language2[$index], true) !!}@endif">
                  @endif
                  <button data-input="{!! $locale2 . '-' . $index !!}" data-original-value="{!! (array_key_exists($index, $language2) ? print_r($language2[$index], true) : '') !!}" type="submit" class="btn btn-primary btn-sm save-string" title="Save"><i class="glyphicon glyphicon-save icon-white"></i></button>
                  <button data-input="{!! $locale2 . '-' . $index !!}" type="submit" class="btn btn-info btn-sm online-translate" title="Online Translation"><span class="glyphicon glyphicon-globe icon-white"></span><span class="sr-only">Save Second Language String</span></button>
                  </span>
               </td>
            </tr>
         @endforeach
