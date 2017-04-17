/**
 * 菜单 sessionStorage
 * @param  {[type]} $ [description]
 * @return {[type]}   [description]
 */
/*(function($){
  $('.sidebar-menu li a').on('click', function(event){
    var index = $(this).index('.sidebar-menu a')
    sessionStorage.menu_index = index;
  })
  if(sessionStorage.menu_index != undefined){
    $('.sidebar-menu .active').removeClass('active')
    var index = sessionStorage.menu_index
    var cur_menu = $('.sidebar-menu a').eq(index)
    cur_menu.parents('li').addClass('active');
    cur_menu.parents('.treeview').addClass('active')
    cur_menu.parents('.treeview-menu').addClass('menu-open')
  }
}(jQuery))*/


/**
 * 常用功能封装
 * @type {Object}
 *
 * @method  deleteConfirm(title, content, callback)  操作确认，支持参数自动补全
 * @method  msg(msg, callback) 一般提示语
 * @method  warning(msg, callback) 一般警告框
 * @object  pluginInit 插件初始化对象
 *          @method  datepicker(selector, config)  日期选择插件
 *          @method  datetimepicker(selector, config) 日期时间选择插件
 *          @method  ickeck(selector, config)  iCheck 插件
 *
 * @method  submitClick(obj, beforePost, callback, isDisable) ajax表单提交，作用于提交按钮
 * @method  modalSubmitClick(obj, beforePost, callback, reload) 模态框表单 aja 提交
 * @method  trDelete(obj, id, url, callback) 表格删除行
 * @method  uploadImg(callback, url) 图片上传
 */
var bayMax = {
  /**
   * 插件集
   */
  /**
   * 模态框
   * 基于 jQuery confirm 插件
   */
  /** 确定删除 询问 */
  deleteConfirm : function(title, content, callback){
    var _title    = '删除',
        _content  = '确定要删除吗？';
    if (arguments.length != 0) {
      if (typeof title === 'function') {
        callback = title;
      } else if (typeof content === 'function') {
        callback = content;
        _title   = title;
      }else {
        _title   = title;
        _content = content || _content;
      }
    }

    $.confirm({
        title   : _title,
        content : _content,
        type    : 'red',
        icon    : 'fa fa-warning',
        buttons : {
            yes : {
                text : '确定',
                btnClass : 'btn-red',
                keys : ['enter'],
                action : function(){
                    if(typeof callback === 'function')
                        callback.call();
                }
            },
            no : {
                text : '取消',
            }
        },
    })
  }, // ./end of deleteConfrim 

  /** 提示 普通信息提示 */
  msg : function(msg, callback){
    var _msg = msg || '提示'
    $.alert({
      title   : false,
      type    : 'dark',
      content : _msg,
      buttons : {
        ok : {
          text   : 'OK',
          action : function(){
            if(typeof callback === 'function'){
              callback.call();
            }
          },
        }
      }
    })
  },
/** 警告框 */
  warning : function(msg, wait){
    wait      = wait || 2000;
    msg       = msg || '警告信息';
    autoClose = 'close|'+wait;
    $.alert({
      title : '警告',
      type : 'red',
      icon : 'fa fa-warning',
      content : msg,
      autoClose : autoClose,
      buttons : {
        close : {
          text : '关闭',
        }
      }
    })
  },

  /**
   * 插件初始化
   *
   * @method datepicker(selector, config)
   * @method datetimepicker(selector, config)
   * @method icheck(selector, config)
   */
  
  pluginInit : {
    // Plugin : datepicker
    datepicker : function(selector, config){
      config = $.extend({
        language  : 'zh-CN',
        format    : 'yyyy-mm-dd',
        autoclose : true
      }, config);
      $(selector).datepicker(config);
    },

    // Plugin : datetimerpick
    datetimepicker : function(selector, config) {
      config = $.extend({
          'language'       : 'zh-CN',
          'weekStart'      : 1,
          'autoclose'      : true,
          'minView'        : 'hour',
          'todayHighlight' : true,
      }, config);
      $(selector).datetimepicker(config);
    },

    // Plugin : icheck
    icheck : function(selector, config){
      config = $.extend({
        checkboxClass : 'icheckbox_square-green',
        radioClass    : 'iradio_square-green'
      }, config);
      $(selector).iCheck(config);
    }
  },

  /**
   * ajax 表单提交
   */
  /**
   * 表单提交按钮点击
   * @param  {dom}   obj        js dom 对象，提交按钮
   * @param  {Function}   beforePost 发送数据之前的函数注入, 可用于数据修改、验证、过滤等
   * @param  {Function} callback   回调函数
   * @param  {boolean}  isDisable  是否禁用提交按钮 默认为 true
   */
  submitClick : function(obj, beforePost, callback, isDisable){
    var self  = this,
        $btn  = $(obj),
        $form = $btn.closest('form');

    isDisable = isDisable !== 'undefined' ? isDisable : true;
    if (isDisable) {
      $btn.prop('disabled', true)
    }
    $form.on('submit', function(){return false;});

    var url  = $form.attr('action'),
        data = $form.serializeArray();
    if (typeof beforePost === 'function') {
      beforePost(data)
    }
    
    $.post(url, data, function(res){
      if (typeof callback === 'function') {
        callback(res);
      } else {
        if (res.code) {
          self.msg(res.msg);
        } else {
          self.warning(res.msg)
        }
      }
    });
  },

  /**
   * 模态框表单提交
   * @param  {object}   obj        js dom 对象，提交按钮
   * @param  {Function}   beforePost 发送前置方法
   * @param  {Function} callback   回调函数
   * @param  {boolean}   reload     是否重载页面，默认为 true
   */
  modalSubmitClick : function(obj, beforePost, callback, reload) {
    var self   = this,
        $modal = $(obj).closest('.modal');
    // 是否重载页面
    reload = typeof reload != 'undefined' ? reload : true;
    if (reload) {
      $modal.one('hidden.bs.modal', function(){
        $.pjax.reload('#pjax-container');
      });
    }
    if (typeof callback !== 'function') { // 默认回调行为
      callback = function(res) {
        if (res.code) {
          $modal.modal('hide');
        } else {
          self.warning(res.msg)
        }
      };
    }

    this.submitClick(obj, beforePost, callback, false)
  },

  /**
   * 表格删除行
   * @param  {object}   obj      js dom 对象，删除按钮
   * @param  {int}   id          数据 id
   * @param  {string}   url      请求地址
   * @param  {Function} callback 回调函数
   */
  trDelete : function(obj, id, url, callback) {
    var self = this,
        $tr  = $(obj).closest('tr');
    this.deleteConfirm(function(){
      $.post(url, {id:id}, function(res){
        if (typeof callback === 'function') {
          callback(res);
        } else {
          if (res) {
            $tr.remove();
          } else {
            self.warning('删除失败');
          }
        }
      });
    });
  },
  /**
   * 上传
   */
  uploadImg : function(callback, url) {
    var self = this;
    var form = new FormData();
    var file = '';
    url = url || '/admin/upload/image.html';

    var fileTag = '<input type="file" accept="image/jpg,image/jpeg,image/png,image/gif">';
    $(fileTag).on('change', function(){
      file = this.files[0];
      if (file.size > 5242880) { // 图片大小不超过 5M 5242880
        self.warning('图片大小不超过 5M');return false;
      }
      form.append('file', file);

      $.ajax({
        url : url,
        type : 'POST',
        cache : false,
        data : form,
        processData : false,
        contentType : false
      }).done(callback);
      
    }).trigger('click');
  },

  _validatePlugin : function(){
    if(typeof $.alert == 'undefined'){
      throw '插件未引入';
    }
  }

};