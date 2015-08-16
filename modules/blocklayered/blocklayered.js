
var ajaxQueries = new Array();
var resultCache = new Array();
var ajaxLoaderOn = 0;
var firstLoad = true;
var processScroll = true;

function handleScroll()
{
    if (nextPage && processScroll) {
        $seeMoreTop = $('#load_more').offset().top;
        if (nextPage > 1 && nextPage < 5)
            if (($(window).scrollTop() + $(window).height()) > $seeMoreTop + 100)
            {
                processScroll = false;
                load_last_pane();
            }
    }
    scrollTop = $(window).scrollTop();

    if (scrollTop > (offsetTop + 280))
        $('#go-to-top').css('display', 'block')
    else
    {
        $('#go-to-top').css('display', 'none');
    }

    scrolling = false;
}

function load_last_pane() {
    $('#see_more').hide();
    $('#loading').show();
    ajaxLoaderOn = 1;

    if (nextPage == undefined || nextPage == null)
        nextPage = 2;
    p = '&p=' + nextPage;
    loadNextPageContent(p);
}

function loadNextPageContent(p)
{
    var dataString = getDataString('') + p + '&al=1';
    ajaxQuery = $.ajax(
            {
                type: 'GET',
                url: (typeof b1g1 !== 'undefined') ? baseDir + 'buy1-get1?ajax=1' : baseDir + 'modules/blocklayered/blocklayered-ajax.php',
                data: dataString,
                dataType: 'json',
                success: function(result) {
                    resultCache[dataString] = result;
                    renderNextPage(result);
                }
            });

    ajaxQueries.push(ajaxQuery);
}

function autoLoadPage(page)
{
    if (page > $.cookie('page'))
    {
        $.scrollTo('li.ajax_block_product[rel="' + $.cookie('scrollTo') + '"]', 0);
        $.removeCookie('page');
        $.removeCookie('scrollTo');
        return;
    }

    var dataString = getDataString('') + '&p=' + page;
    +'&al=1';

    ajaxQuery = $.ajax(
            {
                type: 'GET',
                url: baseDir + 'modules/blocklayered/blocklayered-ajax.php',
                data: dataString,
                dataType: 'json',
                success: function(result) {
                    resultCache[dataString] = result;
                    renderNextPage(result);
                    autoLoadPage(page + 1);
                }
            });
}

$(document).ready(function()
{
    if (typeof(nextPage) == "undefined")
        return;
    cancelFilter();
    openCloseFilter();

    $('.product_card a').live('click', function(e) {
        $.cookie('page', nextPage - 1);
        $.cookie('scrollTo', $(this).parent().parent().attr('rel'));
    });


    $('#layered_form input[type=button]').live('click', function()
    {
        if (!$('\'input[name=' + $(this).attr('name') + ']:hidden\'').length)
            $('<input />').attr('type', 'hidden').attr('name', $(this).attr('name')).val($(this).attr('rel')).appendTo('#layered_form');
        else
            $('\'input[name=' + $(this).attr('name') + ']:hidden\'').remove();
        reloadContent();
    });

    $('#layered_form label.category').live('click', function(e)
    {
        if (!$('\'input[name=' + $(this).attr('name') + ']:hidden\'').length)
            $('<input />').attr('type', 'hidden').attr('name', $(this).attr('name')).val($(this).attr('rel')).appendTo('#layered_form');
        else
            $('\'input[name=' + $(this).attr('name') + ']:hidden\'').remove();
        $('#id_category_layered').val($(this).attr('rel'));
        reloadContent();
    });

    $('#layered_form input[type=checkbox]').live('click', function(e)
    {
        reloadContent();
    });

    $('li.clickable').live('click', function(e) {
        var $target = $(e.target);
        if (!$target.is("li")) {
            return;
        }
        if ($(this).children(':checkbox').length)
        {
            var $checkbox = $(this).children(':checkbox');
            $checkbox.attr('checked', !$checkbox[0].checked);
            reloadContent();
            return;
        }

        if ($(this).children('label.category').length)
        {
            var $label = $(this).children('label.category');
            if (!$('\'input[name=' + $label.attr('name') + ']:hidden\'').length)
                $('<input />').attr('type', 'hidden').attr('name', $label.attr('name')).val($label.attr('rel')).appendTo('#layered_form');
            else
                $('\'input[name=' + $label.attr('name') + ']:hidden\'').remove();
            $('#id_category_layered').val($label.attr('rel'));
            reloadContent();
            return;
        }
    });

    if (typeof(nextPage) != "undefined")
    {
        $(window).scroll(handleScroll);
        offset = $("#top-marker").offset();
        offsetTop = offset.top;
    }
    else
        offsetTop = 0;

    $('#go-to-top').click(function() {
        $.scrollTo('#header', 500);
    });

    $('#load_more').click(function() {
        processScroll = false;
        load_last_pane();
    });

    $(window).bind('hashchange', function() {
        var hash = window.location.hash || '/';
        hash = hash.replace('#', '');
        fireAjax(hash);
    });

    $('.lnk_sort').live('click', function(e) {

        e.preventDefault();
        var splitData = $(this).attr('rel').split(':');
        $('#orderby').val(splitData[0]);
        $('#orderway').val(splitData[1]);
        reloadContent();
    });

    $(window).trigger("hashchange");
    if ($.cookie('page') > 1 && typeof(nextPage) != "undefined")
        autoLoadPage(2);
});

function bindAddToBags() {
    config = {
        over: function(e) {
            id = $(this).attr('rel');
            $('#ajax_id_product_' + id).fadeIn('slow');
        },
        timeout: 500, // number = milliseconds delay before onMouseOut
        out: function() {
            id = $(this).attr('rel');
            $('#ajax_id_product_' + id).fadeOut('fast');
        },
        sensitivity: 3,
        interval: 100
    };
    $('.ajax_block_product').hoverIntent(config);
    ajaxCart.overrideButtonsInThePage();
}

function cancelFilter()
{
    $('#enabled_filters a.lnk_removefilter').live('click', function(e)
    {
        $('#' + $(this).attr('rel')).attr('checked', false);
        $('#layered_form input[name=' + $(this).attr('rel') + ']:hidden').remove();
        reloadContent();
        e.preventDefault();
    });

    $('#selected_category').live('click', function(e)
    {
        if (parentCategory > 1)
            $('#layered_form input[name=id_category_layered]:hidden').val(parentCategory);
        else
            $('#layered_form input[name=id_category_layered]:hidden').remove();
        reloadContent();
        e.preventDefault();
    });
}

function openCloseFilter()
{
    $('#layered_form span.layered_close a').live('click', function(e)
    {
        if ($(this).html() == '&lt;')
        {
            $('#' + $(this).attr('rel')).show();
            $(this).html('v');
        }
        else
        {
            $('#' + $(this).attr('rel')).hide();
            $(this).html('&lt;');
        }

        e.preventDefault();
    });
}

function reloadContent(params_plus)
{
    for (i = 0; i < ajaxQueries.length; i++)
        ajaxQueries[i].abort();
    ajaxQueries = new Array();

    if (!ajaxLoaderOn)
    {
        $('#product_list').prepend($('#layered_ajax_loader').html());
        $('#product_list').css('opacity', '0.7');
        ajaxLoaderOn = 1;
    }

    var dataString = getDataString(params_plus);
    fireAjax(dataString);
}

function getDataString(params_plus)
{
    data = $('#layered_form').serialize();
    $('.layered_slider').each(function() {
        data += '&' + $(this).attr('id') + '=' + $(this).slider('values', 0) + '_' + $(this).slider('values', 1);
    });

    if ($('#selectPrductSort').length)
    {
        var splitData = $('#selectPrductSort').val().split(':');
        var currentOrderWay = splitData[1] == 'asc' ? 'desc' : 'asc';
        data += '&orderby=' + splitData[0] + '&orderway=' + currentOrderWay;
    }

    if (params_plus == undefined)
        params_plus = '';

    if (srch_query)
        data = data + '&search_query=' + srch_query;
    if (brand)
        data = data + '&id_manufacturer=' + brand;
    if (latest)
        data = 'latest=' + latest + '&' + data;
    if (sale)
        data = 'sale=' + sale + '&' + data;
    if (express_shipping)
        data = 'express_shipping=' + express_shipping + '&' + data;
    if (cat_id)
        data = 'cat_id=' + cat_id + '&' + data;
    // push the state on hash
    return data + params_plus;
}

function fireAjax(dataString) {
    if (dataString == '/')
    {
        if (!firstLoad)
            window.location.href = window.location.href;

        return;
    }
    firstLoad = false;
    if (resultCache[dataString])
    {
        populateBlocks(resultCache[dataString]);
        return;
    }
    if (!ajaxLoaderOn)
    {
        $('#product_list').prepend($('#layered_ajax_loader').html());
        $('#product_list').css('opacity', '0.7');
        ajaxLoaderOn = 1;
    }
    ajaxQuery = $.ajax(
            {
                type: 'GET',
                url: baseDir + 'modules/blocklayered/blocklayered-ajax.php',
                data: dataString,
                dataType: 'json',
                success: function(result) {
                    resultCache[dataString] = result;
                    populateBlocks(result);
                    window.location.hash = dataString;
                }
            });

    ajaxQueries.push(ajaxQuery);
}

function populateBlocks(result)
{
    $('#productsHeading').html(result.productsTitle);
    $('#layered_block_left').after('<div id="tmp_layered_block_left"></div>').remove();
    $('#tmp_layered_block_left').html(result.filtersBlock).attr('id', 'layered_block_left');

    $('.product_list').html(result.productList).html();
    $('.product_list').css('opacity', '1');
    $('div#pagination').html(result.pagination);
    $('div.nresults').html('<span class="big">' + result.totalItems + '</span>&nbsp;results');
    bindAddToBags();
    ajaxLoaderOn = 0;

    $('#go-to-top').click(function() {
        $.scrollTo('#header', 500);
    });

    nextPage = parseInt(result.nextPage);
    if (nextPage)
    {
        processScroll = true;
        $('#load_more').show();
        $('#see_more').show();
        $('#loading').hide();
    }
    else
        $('#load_more').hide();

    if (result.sortInfo.length > 1)
    {
        var sortinfo = result.sortInfo.split(':');
        $('#orderway').val(sortinfo[1]);
        if (sortinfo[1] == 'asc')
            sortinfo[1] = 'desc';
        else
            sortinfo[1] = 'asc';

        $('#orderby').val(sortinfo[0]);

        $('.lnk_sort').removeClass('currentsort');
        if (sortinfo[0] == 'price')
        {
            if (sortinfo[1] == 'desc')
                $('.lnk_sort.price').attr('rel', sortinfo[0] + ":" + sortinfo[1]).html(' Price ↓').addClass('currentsort');
            else
                $('.lnk_sort.price').attr('rel', sortinfo[0] + ":" + sortinfo[1]).html(' Price ↑').addClass('currentsort');
        }
        else if (sortinfo[0] == 'discount')
        {
            $('.lnk_sort.discount').attr('rel', sortinfo[0] + ":desc").html(' Discount').addClass('currentsort');
        }
        else if (sortinfo[0] == 'hot')
        {
            $('.lnk_sort.hot').attr('rel', sortinfo[0] + ":desc").html(' Whats Hot').addClass('currentsort');
        }
        else if (sortinfo[0] == 'new')
        {
            $('.lnk_sort.new').attr('rel', sortinfo[0] + ":desc").html(' Whats New').addClass('currentsort');
        }
    }

    $.scrollTo('#header', 500);
}

function renderNextPage(result)
{
    $('.product_list').append(result.productList);
    nextPage = parseInt(result.nextPage);
    ajaxLoaderOn = 0;
    if (nextPage)
    {
        processScroll = true;
        $('#see_more').show();
        $('#loading').hide();
    }
    else
        $('#load_more').hide();

    bindAddToBags();
}
