/**
 * 菜单折叠
 */
$('#sidebar-menu').metisMenu();
/**
 * 吐司提示
 */
$('[data-toggle="tooltip"]').tooltip();

function alert(msg, type, callbak) {

    var shift;
    var time;
    if(msg !==undefined && msg.length == 0){
        return false;
    }

    if(type == 'success'){
        shift = 5;
        time  = 1;
    }else if(type == 'error'){
        shift = 6;
        time  = 2;
    }else{
        shift = 6;
        time  = 2;
    }

    if(callbak == ''){
        callbak = function () {
        };
    }

    time = time * 1000;
    layer.msg(msg, {time:time, shift: shift}, callbak);
}

/**
 * 优化的确认框
 * @param msg 确认框消息
 * @param ok 确认回调函数
 */
function confirm(msg, callback) {
    var d = dialog({
        fixed: true,
        width: '280',
        title: '温馨提示',
        content: msg,
        lock: true,
        opacity: .1,
        okValue: '确定',
        ok: function () {
            if(typeof callback === "function") {
                callback();
                return true;
            }
            return false;
        },
        cancelValue: '取消',
        cancel: function () {
            d.close().remove();
            return false;
        }
    });

    d.showModal();
    return false;

}

/**
 * 重置表单
 */
function resetForm() {
    $(':input','form')
        .not(':button, :submit, :reset, :hidden')
        .val('')
        .removeAttr('checked')
        .removeAttr('selected');
}

$(":reset").on('click', function (e) {
    var e = e||window.event;

    e.stopPropagation(); // 阻止冒泡事件
    e.preventDefault(); // 兼容标准浏览器
    e.returnValue = false; // 兼容IE6~8
    resetForm();
});

/**
 * iframe模态框
 */
(function($){

    $("[data-modal]").on('click',function(e){

        var e = e||window.event;

        e.stopPropagation(); // 阻止冒泡事件
        e.preventDefault(); // 兼容标准浏览器
        e.returnValue = false; // 兼容IE6~8

        var thisObj = $(this);

        var scroll  = thisObj.data('scroll'); // 是否滚动
        var center  = thisObj.data('center'); // 是否居中
        var title   = thisObj.data('title');
        var src     = thisObj.data('src');
        var height  = thisObj.data('height');
        var okBtnShow  = thisObj.data('ok-btn-show');

        var modal   = thisObj.data('modal');
        var iframe  = $(modal).find('iframe');

        if(!modal || !iframe || !src){
            return false;
        }

        if(scroll){
            $(iframe).attr('scroll', scroll);
        }else{
            $(iframe).attr('scroll', 'auto');
        }

        if(title){
            $(modal).find('.modal-title').text(title);
        }

        if(typeof(center) == undefined){
            center = 'true';
        }

        if(typeof(okBtnShow) == undefined){
            okBtnShow = 'true';
        }

        if(okBtnShow == false){
            console.log('9999');
            $(modal).find('button:submit').hide();
        }

        if(height){
            $(iframe).css("height", height);
        }else{
            $(iframe).css("height", 300);
        }

        if(center == true){
            $(modal).on('show.bs.modal', function () {
                $(this).css('display', 'block');
                var modalHeight = $(window).height() / 2 - $(this).find('.modal-dialog').height() / 2;
                $(this).find('.modal-dialog').css({'margin-top': modalHeight});
            });
        }

        $(iframe).attr('src', src);

        setTimeout(function () {
            $(modal).modal('show');
        }, 500);

        $(document).delegate("button:submit", 'click',function(e){

            var e = e||window.event;
            e.stopPropagation();
            e.preventDefault(); // 兼容标准浏览器
            window.event.returnValue = false; // 兼容IE6~8

            $(iframe).contents().find("form").find("input:hidden").trigger('click');

        });

    });

})(jQuery);
/**
 * 表单验证
 */
(function($){
    $.fn.validateForm = function(options){

        var modalObj  = $(window.parent.document).find('#js_popModal');
        var submitObj = modalObj.find(":submit");

        var defaults = {
            before: '',
            success: function (json) {
                parent.location.reload();
            },
            error: ''

        };

        var thisObj = $(this);
        var config  = $.extend(defaults, options);
        var before  = config.before;
        var success = config.success;
        var error   = config.error;

        thisObj.Validform({

            tiptype:function(msg,o){

                if(!o.obj.is("form")){

                    if(3 == o.type){
                        alert(msg, 'error');
                    }

                }
            },

            label:"label",

            btnSubmit: '#js_submit',

            ajaxPost:true,

            beforeSubmit: function () {

                submitObj.attr("disabled", "disabled");

                if(before && before() === false){

                    return false;
                }

            },
            callback:function(json){

                if(json.status == 'success'){

                    alert(json.message, 'success', function () {
                        success(json);
                    });
                }else{

                    error(json);

                    $(".js_" + json.label).focus().addClass('Validform_error');
                    submitObj.removeAttr("disabled");
                    alert(json.message, 'error');
                }

            }

        });

    };
})(jQuery);
