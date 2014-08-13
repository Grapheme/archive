
<?
#Helper::tad($element->metas->where('language', $locale_sign)->first());
#Helper::ta($element);
$element_meta = new I18nNewsMeta;
foreach ($element->metas as $tmp) {
    #Helper::ta($tmp);
    if ($tmp->language == $locale_sign) {
        $element_meta = $tmp;
        break;
    }
}
?>
<section>
    <label class="label">Название</label>
    <label class="input">
        {{ Form::text('locales['.$locale_sign.'][title]', $element_meta->title) }}
    </label>
</section>
<section>
    <label class="label">Анонс</label>
    <label class="textarea">
        {{ Form::textarea('locales['.$locale_sign.'][preview]', $element_meta->preview, array('class'=>'redactor redactor_150')) }}
    </label>
</section>
<section>
    <label class="label">Содержание</label>
    <label class="textarea">
        {{ Form::textarea('locales['.$locale_sign.'][content]', $element_meta->content, array('class'=>'redactor redactor_450')) }}
    </label>
</section>