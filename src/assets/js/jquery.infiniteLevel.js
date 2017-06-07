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
            var element = $(this);
            element.on('change', 'select', function () {
                var that = $(this),
                    input = $('input:hidden', element),
                    selectedVal = $.trim(that.val()),
                    level = that.data('level') || 0,
                    inputVal, childSelected;

                if (selectedVal) {
                    inputVal = selectedVal;
                } else if (level > 0) {
                    inputVal = $("select:eq("+(level-1)+")", element).val();
                } else {
                    inputVal = '';
                }

                childSelected = _options['itemParents'][level+1] || '';

                var col = $('div[class^=col-md-]', element);
                clearSubLevel(col, level);
                if (selectedVal && _options.items[selectedVal]) {
                    rebuildLevel(element, _options.items[selectedVal], level, childSelected);
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
                    segments.push('<option value="'+v.value+'" '+ ((selected == v.value) ? ' selected=""' :'')+'>'+v.label+'</option>');
                });

                dom.find('select').empty().html(segments);

                dom.appendTo(obj);
            }
        });
    }
})(jQuery, window, document);