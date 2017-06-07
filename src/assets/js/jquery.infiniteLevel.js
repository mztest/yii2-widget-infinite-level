/**
 * Created by guoxiaosong on 2016/10/25.
 */
(function($, window, document){
    $.fn.infinityLevel = function(options) {
        var _options = {
            items: {},
            itemParents: []
        };
        
        options && $.extend(_options, options);

        this.each(function() {
            var element = $(this), inner = element.find('.row');
            element.on('change', 'select', function () {
                var that = $(this),
                    input = $('input:hidden', element),
                    selectedVal = $.trim(that.val()),
                    level, inputVal, childSelected;

                level = that.data('level') || 0;
                if (selectedVal) {
                    inputVal = selectedVal;
                } else if (level > 0) {
                    inputVal = $("select:eq("+(level-1)+")", inner).val();
                } else {
                    inputVal = '';
                }

                childSelected = _options['itemParents'][level+1] || 0;

                var col = $('div[class^=col-md-]', inner);
                clearSubLevel(col, level);
                if (selectedVal && _options.items[selectedVal]) {
                    rebuildLevel(inner, _options.items[selectedVal], level, childSelected);
                    input.val(inputVal);
                    $('select:last', element).change();
                } else {
                    input.val(inputVal);
                }
            });
            $('select:first', element).change();

            function clearSubLevel(col, level) {
                // clear sub level select.
                $.each(col, function () {
                    if ($(this).find('select').data('level') > level) {
                        $(this).remove();
                    }
                });
            }
            function rebuildLevel(obj, data, level, selected) {
                var col = obj.find('div[class^=col-md-]'),
                    dom = $(col[0]).clone();

                dom.find('select').data('level', level + 1);

                var segments = [],
                    firstOption = dom.find('option:first');

                if (!firstOption.attr('value')) {
                    segments.push(firstOption);
                }

                $.each(data, function(i, v) {
                    segments.push('<option value="'+v.value+'" '+ ((selected == i) ? ' selected=""' :'')+'>'+v.label+'</option>');
                });

                dom.find('select').empty().html(segments);

                dom.appendTo(obj);
            }
        });
    }
})(jQuery, window, document);