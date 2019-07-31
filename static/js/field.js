// 选择header
function selectHeader(headerParams) {
    var selectHeaderBtn = $('#headerParamTable .js_name');
    selectHeaderBtn.typeahead({
        source: headerParams,
        items: 8, //显示8条
        delay: 100, //延迟时间
        autoSelect:false

    });
}
// 选择类型
function selectType(object) {
    var type = ["array", "object"];

    var thisObj = $(object);
    var thisTrObj = thisObj.closest('tr');
    var addBtnObj = thisTrObj.find('.js_addField');

    var nextTrObj = thisTrObj.next("tr");

    var thisLevel = thisTrObj.find("input.js_level").val();
    var nextLevel = nextTrObj.find("input.js_level").val();

    if(!thisLevel){
        thisLevel = 0;
    }

    if(!nextLevel){
        nextLevel = 0;
    }

    if($.inArray(thisObj.val(), type) < 0){
        addBtnObj.attr("disabled", true);
    }else{
        addBtnObj.attr("disabled", false);
    }

    if(thisLevel >= nextLevel){
        thisObj.children('option').attr("disabled",false);
    }else{
        thisObj.children('option').not('option[value="array"],option[value="object"]').attr("disabled",true);
    }
}

// 新增字段
function addField(object, type) {

    var thisObj = $(object);
    var tableObj = thisObj.closest('.row').find('.table');
    var TrObj = thisObj.closest('tr');
    var level = parseInt(TrObj.find('input.js_level').val());

    if(type == 'header'){
        var cloneObj = $('.clone-table .js_headerClone').clone(true);
    }else if(type == 'request'){
        var cloneObj = $('.clone-table .js_requestClone').clone(true);
    }else if(type == 'response'){
        var cloneObj = $('.clone-table .js_responseClone').clone(true);
    }

    if(level >= 0){
        var pl = (level+1) * 10 + 12;
    }else{
        var pl = 12;
    }

    if(TrObj.length > 0){
        cloneObj.find("input.js_level").val(level + 1).data('level', level + 1);
        TrObj.after(cloneObj).next('tr').find('input.js_name').css('padding-left', pl + 'px').focus();
    }else{

        cloneObj.find("input.js_level").val(0);
        cloneObj.appendTo(tableObj).find('input:eq(0)').focus();
    }

    $('.js_type').trigger("change");

    selectHeader(["Accept","Accept-Charset","Accept-Encoding","Accept-Language","Accept-Datetime","Accept-Ranges","Authorization","Cache-Control","Connection","Cookie","Content-Disposition","Content-Length","Content-Type","Content-MD5","Referer","User-Agent","X-Requested-With","X-Forwarded-For","X-Forwarded-Host","X-Csrf-Token"]);

}

// 删除字段
function deleteField(btn) {
    var thisObj = $(btn).closest('tr');
    var preObj  = thisObj.prev("tr");
    var nextObj = thisObj.next("tr");

    var thisLevel = thisObj.find("input.js_level").val();
    var preLevel  = preObj.find("input.js_level").val();
    var nextLevel = nextObj.find("input.js_level").val();

    if(!thisLevel){
        thisLevel = 0;
    }

    if(!preLevel){
        preLevel = 0;
    }

    if(!nextLevel){
        nextLevel = 0;
    }

    // console.log(thisLevel);
    // console.log(nextLevel);

    if(thisLevel >= nextLevel){
        thisObj.remove();
        // 让非复合选项可选
        $('.js_type').trigger("change");
    }else{
        alert('请先删除子参数');return;
    }
}

function replaceAll(originalStr,oldStr,newStr){
    var regExp = new RegExp(oldStr,"gm");
    return originalStr.replace(regExp,newStr)
}

// 根据表格获取json字符串
function getTableJson(tableId) {
    
    var trObj = $('#' + tableId).find('tbody').find('tr');

    if(trObj.length <= 0){
        return '';
    }

    var json = "[";
    var i = 0;
    var j = 0;

    trObj.each(function() {
        i = i + 1;
        j = 0;
        if (i != 1){
            json += ",";
        }

        json += "{";
        $(this).find('td').find('input').each(function(i, val) {
            j = j + 1;
            if (j != 1){
                json += ",";
            }
            json += "\"" + val.name + "\":\"" + replaceAll(val.value,'"','\\"') + "\""
        });
        $(this).find('td').find('select').each(function(i, val) {
            j = j + 1;
            if (j != 1){
                json += ",";
            }

            json += "\"" + val.name + "\":\"" + replaceAll(val.value,'"','\\"') + "\""
        });
        json += "}"
    });
    json += "]";
    return json;
}

// 取消保存
function cancelSave() {
    confirm('您编辑的内容还没有保存，确定要退出吗？', function () {
        window.location.reload();
    });
}

// 添加表单验证
function submitForm(submitBtn) {

    $("form").Validform({

        tiptype:function(msg,o){

            if(!o.obj.is("form")){

                if(3 == o.type){
                    alert(msg, 'error');
                }

            }
        },

        label:"label",

        btnSubmit: submitBtn,

        tipSweep:true,

        ignoreHidden:true,

        ajaxPost:true,

        beforeSubmit: function () {

            $(submitBtn).attr("disabled", "disabled");

            $(".js_headerJson").val(getTableJson('headerParamTable'));
            $(".js_requestJson").val(getTableJson('requestParamTable'));
            $(".js_responseJson").val(getTableJson('responseParamTable'));

        },

        callback:function(json){

            if(json.status == 'success'){

                alert(json.message, 'success', function () {
                    parent.location.reload();
                });

            }else{

                $(".js_" + json.label).focus().addClass('Validform_error');
                $(submitBtn).removeAttr("disabled");
                alert(json.message, 'error');

            }

        }
    });
}