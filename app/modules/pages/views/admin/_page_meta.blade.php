
<?
#Helper::tad($element->metas->where('language', $locale_sign)->first());
$element_meta = new PageMeta;
foreach ($element->metas as $tmp) {
    #Helper::ta($tmp);
    if ($tmp->language == $locale_sign) {
        $element_meta = $tmp;
        break;
    }
}
?>
    <section>
        <label class="label">Шаблон</label>
        <label class="input select input-select2">
            {{ Form::select('locales[' . $locale_sign . '][template]', array('По умолчанию')+$templates, $element_meta->template) }}
        </label>
    </section>

<span><!-- .smart-form fieldset + fieldset border-top 1px fix --></span>

<div class="clearfix margin-bottom-10">

    {{ ExtForm::seo('seo['.$locale_sign.']', $element_meta->seo) }}

</div>