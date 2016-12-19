$(document).ready(function() {
    $('[data-type=event]').click(function () {
        window.location.href='subscribeResponse';
    });
    $('[data-type=message]').click(function () {
        window.location.href='msgResponse';
    });
    $('[data-type=keyword]').click(function () {
        window.location.href='keywordResponse';
    });
    //选择素材后界面元素更新 ok
    $('.modal-content').find('.modal-footer').find('[data-type=ensure]').click(function() {
        $data=$('.modal-content').find('[data-selected=selected]').clone();
        $data.append('<button class="btn btn-default btn-sm btn-block" style="border-radius:0;border-style:solid none none none;"><span class="glyphicon glyphicon-remove"></span> 移除</button>');
        $('.tab-pane.active').empty().append($data);
        $('.tab-pane.active').find('button').click(function(){
            //更新素材选择区的状态
            $('.modal-content').find('[data-selected=selected]').attr('data-selected', '');
            $('.modal-content').find('.modal-footer').find('[data-type=ensure]').addClass('disabled');
            $('.modal-content').find('.modal-footer').find('[data-type=thumb_ensure]').addClass('disabled');
            //克隆模板
            $tpl_mat=$('[data-type=sel_mat_model]').clone().css('display', 'block').attr('data-type', '');
            $tpl_upl=$('[data-type=upload_model]').clone().css('display', 'block').attr('data-type', '');
            //修正进度条和链接操作
            $where=$('.tab-pane.active').attr('id').substr(6);
            switch ($where){
                case 'image':
                    $tpl_upl.find('.progress-bar').attr('id','progressBarImage');
                    break;
                case 'voice':
                    $tpl_upl.find('.progress-bar').attr('id','progressBarVoice');
                    break;
                case 'music':
                    $tpl_upl.find('.progress-bar').attr('id','progressBarThumb');
                    break;
                case 'video':
                    $tpl_upl.find('a').text('本地上传').attr({
                        'href':'#modal-add-video',
                        'data-toggle':"modal",
                        'onclick':null
                    });
                    $tpl_upl.find('.progress-bar').attr('id','progressBarVideo');
                    break;
                case 'news':
                    $tpl_upl.find('a').text('新建图文').attr({
                        'href':'/Home/PdMaterial/addNewsPage',
                        'target':'_blank'
                    });
                    $tpl_upl.find('.progress').hide();
                    break;
            }

            $('.tab-pane.active').empty();
            $('.tab-pane.active').append($tpl_mat).find('[data-toggle=modal]').attr('href', '#modal-container-'+$where);
            $('.tab-pane.active').append($tpl_upl);
        });
        //关闭弹出的界面
        $(this).attr('data-dismiss', 'modal');
    });

    //音乐缩略图选择后的处理 ok
    $('.modal-content').find('.modal-footer').find('[data-type=thumb_ensure]').click(function(){
        $src=$('.modal-content').find('[data-selected=selected]').find('img').attr('src');
        $media_id=$('.modal-content').find('[data-selected=selected]').find('img').attr('data-id');
        $('.modal-content').find('[data-selected=selected]').attr('data-selected','');
        $(this).attr('data-dismiss', 'modal');
        $('.modal-content').find('.modal-footer').find('[data-type=thumb_ensure]').addClass('disabled');
        $('.modal-content').find('.modal-footer').find('[data-type=ensure]').addClass('disabled');
        $('.tab-pane.active').find('img').attr({
            'src':$src,
            'data-id':$media_id
        });
    });

    //视频上传处理 ok
    $('#add_video').click(function () {
        if(!$('#title').val()){
            alert('视频标题不能为空！');
        }else if(!$('#introduction').val().length){
            alert('视频描述不能为空！');
        }else if(!$('#video_file').val().length){
            alert('视频文件不能为空！');
        }else{
            $(this).attr('data-dismiss','modal');
            var xhr = new XMLHttpRequest();
            var filesObj = document.getElementById('video_file').files[0];
            var formData = new FormData();
            formData.append('title',$('#title').val());
            formData.append('introduction',$('#introduction').val());
            formData.append('files', filesObj);
            xhr.open("POST", '/Home/PdMaterial/addVideo', true);
            //设定下载progress事件的处理函数，该事件在数据下载时触发
            xhr.onprogress = updateProgress;
            //设定上传progress事件的处理函数，该事件在数据上传时触发
            xhr.upload.onprogress = updateProgress;
            var progressBar = document.getElementById('progressBarVideo');
            function updateProgress(event){
                //判断服务器是否提供数据长度信息
                if(event.lengthComputable){
                    //计算得到进度数值
                    var percentComplete = event.loaded/event.total;
                    //在控制台记录进度数值
                    //console.log(percentComplete);
                    //更改进度条进度
                    progressBar.style.width = percentComplete*100+'%';
                }
            }
            xhr.send(formData);
            xhr.onreadystatechange = function(){
                if(xhr.readyState==4 && xhr.status==200){
                    $result= xhr.responseText;
                    console.log($result);
                    if($result=='error'){
                        $('#progressBar').css('width','0%');
                        alert('上传失败！');
                    }else{
                        //将进度条清零
                        $('#progressBar').css('width','0%');
                        $date=new Date();
                        $json=JSON.parse($result);
                        $ele=$('<div class="col-xs-12 column cell" data-type="data_box_cell"><div class="col-xs-12 column data_box_video" data-id="'+$json.media_id+'"><div class="col-xs-4 column"><video src="#" width="150" hieght="100"></video></div><div class="col-xs-4 column" name="title">'+$('#title').val()+'</div><div class="col-xs-4 column">'+$date.getFullYear()+'年'+$date.getMonth()+'月'+$date.getDate()+'日'+'</div></div></div>');
                        $ele.css('opacity', '1.0');
                        //为元素添加删除按钮
                        $ele.append('<button class="btn btn-default btn-sm btn-block" style="border-radius:0;border-style:solid none none none;"><span class="glyphicon glyphicon-remove"></span> 移除</button>');
                        $('.tab-pane.active').empty().append($ele);
                        //为新上传的元素添加删除事件
                        $('.tab-pane.active').find('button').click(function () {
                            $tpl_mat = $('[data-type=sel_mat_model]').clone().css('display', 'block').attr('data-type', '');
                            $tpl_upl = $('[data-type=upload_model]').clone().css('display', 'block').attr('data-type', '');
                            //修正进度条和链接操作
                            $tpl_upl.find('a').text('本地上传').attr({
                                'href':'#modal-add-video',
                                'data-toggle':'modal',
                                'onclick':null
                            });
                            $tpl_upl.find('.progress-bar').attr('id','progressBarVideo');
                            //更改界面元素
                            $('.tab-pane.active').empty();
                            $('.tab-pane.active').append($tpl_mat).find('[data-toggle=modal]').attr('href', '#modal-container-video');
                            $('.tab-pane.active').append($tpl_upl);
                        });
                    }
                }
            }
        }
    });

    //保存信息 ok
    $('#save').click(function () {
        $type=$('button.active').attr('data-type');     //获取被回复的类型
        $responseType=$('.tab-pane.active').attr('id').substr(6);   //获取回复类型
        switch ($responseType){
            case 'text':
                $data={'content':$('.tab-pane.active').find('textarea').val()};
                break;
            case 'image':
                $data={
                    'title':$('.tab-pane.active').find('p').text(),
                    'media_id':$('.tab-pane.active').find('img').attr('data-id'),
                    'url':$('.tab-pane.active').find('img').attr('src')
                };
                if(!$data.media_id){
                    alert('请先选择要回复的图片！');
                    return false;
                }
                break;
            case 'voice':
                $data={
                    'media_id':$('.tab-pane.active').find('.data_box_voice').attr('data-id'),
                    'title':$('.tab-pane.active').find('[data-type=file_name]').text()
                };
                if(!$data.media_id){
                    alert('请先选择要回复的语音！');
                    return false;
                }
                break;
            case 'music':
                $data={
                    'title':$('.tab-pane.active').find('[name="title"]').val(),
                    'description':$('.tab-pane.active').find('[name="description"]').val(),
                    'music_url':$('.tab-pane.active').find('[name="music_url"]').val(),
                    'hq_music_url':$('.tab-pane.active').find('[name="hq_music_url"]').val(),
                    'thumb_media_id':$('.tab-pane.active').find('img').attr('data-id'),
                    'thumb_url':$('.tab-pane.active').find('img').attr('src')
                };
                break;
            case 'video':
                $data={
                'media_id':$('.tab-pane.active').find('.data_box_video').attr('data-id'),
                'title':$('.tab-pane.active').find('[name="title"]').text(),
                'description':''
                };
                if(!$data.media_id){
                    alert('请先选择要回复的视频！');
                    return false;
                }
                break;
            case 'news':
                $data={'media_id':$('.tab-pane.active').find('.news_footer').attr('data-id')};
                if(!$data.media_id){
                    alert('请先选择要回复的图文！');
                    return false;
                }
                break;
        }
        if($type=='event'){
            $data.type=$type;
            $data.event=$('button.active').attr('data-key');
            $data.event_key='wgj_default';
        }else{
            $data.type='keyword';
            $data.keyword='wgj_default';
            $data.rule='wgj_default';
        }
        $data.response_type=$responseType;
        $.post('setResponse',$data,function (data) {
            alert(data);
        })

    });

    //删除设置信息（被添加和消息自动回复） ok
    $('#delete').click(function () {
        $type=$('button.active').attr('data-type');     //获取被回复的类型
        $responseType=$('.tab-pane.active').attr('id').substr(6);   //获取回复类型
        $data=new Object();
        if($type=='event'){
            $data.type='event';
            $data.event='subscribe';
            $data.event_key='wgj_default';
        }else{
            $data.type='keyword';
            $data.keyword='wgj_default';
            $data.rule='wgj_default';
        }
        $.post('delResponse',$data,function (data) {
            alert(data);
        })
    });

    /*关键字回复页面操作↓↓*/
    //新建规则面板的toggle动作
    $('#create_rul_btn').click(function(){
        $(".rule_panel").toggle();
    });

    //规则保存处理 ok
    $('#set_keyword_response').click(function () {
        $responseType=$('.tab-pane.active').attr('id').substr(6);   //获取回复类型
        switch ($responseType){
            case 'text':
                $data={'content':$('.tab-pane.active').find('textarea').val()};
                $content=$('.tab-pane.active').find('textarea').val();
                break;
            case 'image':
                $data={
                    'title':$('.tab-pane.active').find('p').text(),
                    'media_id':$('.tab-pane.active').find('img').attr('data-id'),
                    'url':$('.tab-pane.active').find('img').attr('src')
                };
                $content=$('.tab-pane.active').find('[data-type=data_box_cell]').clone();
                $content.find('button').remove();
                if(!$data.media_id){
                    alert('请先选择要回复的图片！');
                    return false;
                }
                break;
            case 'voice':
                $data={
                    'media_id':$('.tab-pane.active').find('.data_box_voice').attr('data-id'),
                    'title':$('.tab-pane.active').find('[data-type=file_name]').text()
                };
                $content=$('.tab-pane.active').find('[data-type=data_box_cell]').clone();
                $content.find('button').remove();
                if(!$data.media_id){
                    alert('请先选择要回复的语音！');
                    return false;
                }
                break;
            case 'music':
                $data={
                    'title':$('.tab-pane.active').find('[name="title"]').val(),
                    'description':$('.tab-pane.active').find('[name="description"]').val(),
                    'music_url':$('.tab-pane.active').find('[name="music_url"]').val(),
                    'hq_music_url':$('.tab-pane.active').find('[name="hq_music_url"]').val(),
                    'thumb_media_id':$('.tab-pane.active').find('img').attr('data-id'),
                    'thumb_url':$('.tab-pane.active').find('img').attr('src')
                };
                $content=$('<p>&nbsp;&nbsp;&nbsp;&nbsp;标题：'+$data.title+'</p><p>&nbsp;&nbsp;&nbsp;&nbsp;描述：'+$data.description+'</p> <p>&nbsp;&nbsp;&nbsp;&nbsp;音乐链接：'+$data.music_url+'</p><p>&nbsp;&nbsp;&nbsp;&nbsp;高品质音乐链接：'+$data.hq_music_url+'</p>'+
                    '<p>&nbsp;&nbsp;&nbsp;&nbsp;音乐贴图：<img class="thumb" src="'+$data.thumb_url+'" width="100" height="70px;" data-id="'+$data.thumb_media_id+'" /></p>');
                break;
            case 'video':
                $data={
                    'media_id':$('.tab-pane.active').find('.data_box_video').attr('data-id'),
                    'title':$('.tab-pane.active').find('[name="title"]').text(),
                    'description':''
                };
                $content=$('.tab-pane.active').find('[data-type=data_box_cell]').clone();
                $content.find('button').remove();
                if(!$data.media_id){
                    alert('请先选择要回复的视频！');
                    return false;
                }
                break;
            case 'news':
                $data={'media_id':$('.tab-pane.active').find('.news_footer').attr('data-id')};
                $content=$('.tab-pane.active').find('[data-type=data_box_cell]').clone();
                $content.find('button').remove();
                if(!$data.media_id){
                    alert('请先选择要回复的图文！');
                    return false;
                }
                break;
        }
        $infoEle=$(this).parents('.panel-footer').siblings('.panel-body');
        $data.type='keyword';
        $data.rule=$infoEle.find('[name="rulename"]').val();
        $data.keyword=$infoEle.find('[name="keyword"]').val();
        $data.response_type=$responseType;
        $.post('keywordResponseAutoSet',$data,function (data) {
            if(data=='创建成功！'){
                $('.panel-collapse.in').removeClass('in').addClass('collapse');
                $infoEle.find('[name="rulename"]').val('');
                $infoEle.find('[name="keyword"]').val('');
                $(".rule_panel").toggle();
                $i=$('.panel.cell').length+1;
                $ele=$('<div class="panel panel-default cell"><div class="panel-heading"> <a class="panel-title" data-toggle="collapse" data-parent="#panel-209920" href="#panel-element-'+$i+'">规则名：<span>'+$data.rule+'</span></a> <button class="btn btn-default btn-sm delete_rule" onclick="delete_rule(this)">删除规则</button></div>'
                    +'<div id="panel-element-'+$i+'" class="panel-collapse in"> <div class="panel-body"> <h4>关键字：</h4> <label>&nbsp;&nbsp;&nbsp;&nbsp;'+$data.keyword+'</label>'
                    +'<hr/><h4>回复内容：</h4><span class="ele_content"></span></div></div></div>');
                $ele.find('span.ele_content').html($content);
                $('#panel-209920').prepend($ele);
                alert(data);
            }else{
                alert(data);
            }
        })
    });


});

//获取素材 ok
function get_material(ele) {
    $type=$(ele).attr('href').substr(17);
    if($type=='thumb'){
        $type='image';
    }
    $offset=$('#modal-container-'+$type).find('[data-type=data_box_cell]').length;
    if(!$offset){
        get_material_from_wechat($type,$offset);
    }
}

//ajax异步获取在线素材 ok
function get_material_from_wechat($type,$offset) {
    //请求要加载的资源
    $.get('/Home/PdMaterial/getMaterialListAjax',{'type':$type,'offset':$offset},function (data) {
        if(data=='error'){
            alert('获取素材失败！');
        }else{
            $list=JSON.parse(data);
            $len=$list.item.length;
            if($len){
                for($i=0;$i<$len;$i+=1){
                    switch($type){
                        case 'image':
                            $ele='<div class="col-sm-3 column cell" data-type="data_box_cell" onclick="add_select_animate(this)"><div class="col-sm-12 column data_box_img"><img src="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl='+$list.item[$i].url+'" height="117" width="100%" data-id="'+$list.item[$i].media_id+'"/><p class="text-center">'+$list.item[$i].name.substr($list.item[$i].name.lastIndexOf('/')+1,15)+'</p></div></div>';
                            $('.modal-body').find('.img_list').append($ele);
                            break;
                        case 'voice':
                            $date=new Date($list.item[$i].update_time*1000);
                            $ele='<div class="col-xs-6 column cell" data-type="data_box_cell" onclick="add_select_animate(this)"><div class="col-xs-12 column data_box_voice" data-id="'+$list.item[$i].media_id+'"><div class="col-xs-4 column"><img src="/Home/PdMaterial/getVoiceDisplayImg" onmouseover="image_scale_animate(this,1.1)" onmouseleave="image_scale_animate(this,1.0)" onclick="voice_listen_online(this)" alt="点击播放" title="点击播放" width="100%" height="70"/> </div> <div class="col-xs-8 column"><p data-type="file_name">'+$list.item[$i].name.substr($list.item[$i].name.lastIndexOf('/')+1,15)+'</p><p>'+$date.getFullYear()+'年'+$date.getMonth()+'月'+$date.getDate()+'日'+'</p></div></div></div>';
                            $('.modal-body').find('.voice_list').append($ele);
                            break;
                        case 'thumb':
                            $ele='<div class="col-sm-3 column cell" data-type="data_box_cell" onclick="add_select_animate(this)"><div class="col-sm-12 column data_box_img"><img src="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl='+$list.item[$i].url+'" height="117" width="100%" data-id="'+$list.item[$i].media_id+'"/><p class="text-center">'+$list.item[$i].name.substr($list.item[$i].name.lastIndexOf('/')+1,15)+'</p></div></div>';
                            $('.modal-body').find('.img_list').append($ele);
                            break;
                        case 'video':
                            $date=new Date($list.item[$i].update_time*1000);
                            $ele='<div class="col-xs-12 column cell" data-type="data_box_cell" onclick="add_select_animate(this)"><div class="col-xs-12 column data_box_video" data-id="'+$list.item[$i].media_id+'"><div class="col-xs-4 column"><video src="#" width="150" hieght="100"></video></div><div class="col-xs-4 column" name="title">'+$list.item[$i].name+'</div><div class="col-xs-4 column">'+$date.getFullYear()+'年'+$date.getMonth()+'月'+$date.getDate()+'日'+'</div></div></div>';
                            $('.modal-body').find('.video_list').append($ele);
                            break;
                        case 'news':
                            if($list.item[$i].content.news_item[1]){    //多图文素材
                                $date=new Date($list.item[$i].update_time*1000);
                                $ele=$('<div class="col-xs-4 column cell" data-type="data_box_cell" onclick="add_select_animate(this)"><div class="col-xs-12 column news_box"><div class="news_header_more"> <h5>'+ $date.getFullYear()+'年'+$date.getMonth()+'月'+$date.getDate()+'日'+'</h5></div><div class="col-xs-12 column news_body"></div><div class="col-xs-12 column news_footer" data-id="'+$list.item[$i].media_id+'"></div></div></div>');
                                $childLen=$list.item[$i].content.news_item.length;
                                for($k=0;$k<$childLen;$k+=1){
                                    if($k==0){
                                        $childEle='<div class="first data_box"><img src="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl='+auto_thumb_url($list.item[$i].content.news_item[$k].thumb_url)+'" width="100%" height="120px"> <h5 class="sm">'+$list.item[$i].content.news_item[$k].title.substr(0,15)+'</h5></div>';
                                        $ele.find('.news_body').append($childEle);
                                    }else{
                                        $childEle='<div class="col-xs-12 column data_box"><div class="col-xs-8 column"><h5>'+$list.item[$i].content.news_item[$k].title.substr(0,15)+'</h5></div><div class="col-xs-4 column"><img width="100%" height="70" src="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl='+auto_thumb_url($list.item[$i].content.news_item[$k].thumb_url)+'"></div></div>'
                                        $ele.find('.news_body').append($childEle);
                                    }
                                }
                            }else{  //单图文素材
                                $date=new Date($list.item[$i].update_time*1000);
                                $ele='<div class="col-xs-4 column cell" onclick="add_select_animate(this)" data-type="data_box_cell"><div class="col-xs-12 column news_box"><div class="news_header_single"><h5>'+ $date.getFullYear()+'年'+$date.getMonth()+'月'+$date.getDate()+'日'+'</h5></div> <div class="col-xs-12 column news_body"> <div class="col-xs-12 column data_box"> <p>'+$list.item[$i].content.news_item[0].title.substr(0,15)+'</p><img src="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl='+auto_thumb_url($list.item[$i].content.news_item[0].thumb_url)+'" width="100%" height="150px"><p>'+$list.item[$i].content.news_item[0].digest+'</p></div></div><div class="col-xs-12 column news_footer" data-id="'+$list.item[$i].media_id+'"></div></div></div>';
                            }
                            $('.modal-body').find('.news_list').append($ele);
                            break;
                    }
                }
                //判断是否显示加载更多操作
                if($len==20){
                    if($type=='image'){
                        $('#modal-container-'+$type).find('.load_more').removeClass('hidden');
                        $('#modal-container-thumb').find('.load_more').removeClass('hidden');
                    }else{
                        $('#modal-container-'+$type).find('.load_more').removeClass('hidden');
                    }
                }else{
                    if($type=='image'){
                        $('#modal-container-'+$type).find('.load_more').addClass('hidden');
                        $('#modal-container-thumb').find('.load_more').addClass('hidden');
                    }else{
                        $('#modal-container-'+$type).find('.load_more').addClass('hidden');
                    }
                }
                //图文素材url转换函数
                function auto_thumb_url(json) {
                    if (json) {
                        return json;
                    } else {
                        return '';
                    }
                }
            }else{
                alert('已无素材！');
                $('#modal-container-'+$type).find('.load_more').addClass('hidden');
            }
        }
    });
}

//加载更多 ok
function load_more(ele) {
    $type=$(ele).attr('data-load');
    if($type=='thumb'){
        $type='image';
    }
    $offset=$('#modal-container-'+$type).find('[data-type=data_box_cell]').length;      //要加载的资源偏移量
    get_material_from_wechat($type,$offset);
}

//上传操作 ok
function upload_file(ele) {
    $type=$(ele).parents('.tab-pane').attr('id').substr(6);
    $progressWhere=$type.toUpperCase().substr(0,1)+$type.substr(1);
    if($type=='music'){
        $type='image';
    }
    $('#file').click();     //打开文件选择窗口
    $('#file').change(function () { //如果发生文件选择事件
        if ($(this).val().length) {       //如果选择的文件名不为空
            var xhr = new XMLHttpRequest();
            var filesObj = document.getElementById('file').files[0];
            var formData = new FormData();
            formData.append('files', filesObj);
            xhr.open("POST", '/Home/PdMaterial/add' + $type.toUpperCase().substr(0, 1) + $type.substr(1), true);
            //设定下载progress事件的处理函数，该事件在数据下载时触发
            xhr.onprogress = updateProgress;
            //设定上传progress事件的处理函数，该事件在数据上传时触发
            xhr.upload.onprogress = updateProgress;
            var progressBar = document.getElementById('progressBar' + $progressWhere);

            function updateProgress(event) {
                //判断服务器是否提供数据长度信息
                if (event.lengthComputable) {
                    //计算得到进度数值
                    var percentComplete = event.loaded / event.total;
                    //在控制台记录进度数值
                    //console.log(percentComplete);
                    progressBar.style.width = percentComplete * 100 + '%';
                }
            }

            xhr.send(formData);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    $result = xhr.responseText;
                    if ($result == 'error') {
                        $('#progressBar').css('width', '0%');
                        alert('上传失败！');
                    } else {
                        $('#progressBar').css('width', '0%');
                        $json = JSON.parse($result);
                        $time = new Date();
                        switch ($type) {
                            case 'image':
                                $ele = $('<div class="col-sm-3 column cell" data-type="data_box_cell"><div class="col-sm-12 column data_box_img"><img src="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl=' + $json.url + '" height="117" width="100%" data-id="' + $json.media_id + '"/><p class="text-center">' + filesObj.name.substr(0, 15) + '</p></div></div>');
                                $ele.css('opacity', '1.0');
                                break;
                            case 'voice':
                                $ele = $('<div class="col-xs-6 column cell" data-type="data_box_cell"><div class="col-xs-12 column data_box_voice" data-id="' + $json.media_id + '"><div class="col-xs-4 column"><img src="/Home/PdMaterial/getVoiceDisplayImg" onmouseover="image_scale_animate(this,1.1)" onmouseleave="image_scale_animate(this,1.0)" onclick="voice_listen_online(this)" alt="点击播放" title="点击播放" width="100%" height="70"/> </div> <div class="col-xs-8 column"><p data-type="file_name"></p>' + filesObj.name.substr(0, 15) + '<p>' + $time.getFullYear() + '年' + ($time.getMonth() + 1) + '月' + $time.getDate() + '日' + '</p></div></div></div>');
                                $ele.css('opacity', '1.0');
                                break;
                        }
                        //为元素添加删除按钮
                        $ele.append('<button class="btn btn-default btn-sm btn-block" style="border-radius:0;border-style:solid none none none;"><span class="glyphicon glyphicon-remove"></span> 移除</button>');
                        $('.tab-pane.active').empty().append($ele);
                        //为新上传的元素添加删除事件
                        $('.tab-pane.active').find('button').click(function () {
                            $tpl_mat = $('[data-type=sel_mat_model]').clone().css('display', 'block').attr('data-type', '');
                            $tpl_upl = $('[data-type=upload_model]').clone().css('display', 'block').attr('data-type', '');
                            //修正进度条和链接操作
                            $where=$('.tab-pane.active').attr('id').substr(6);
                            switch ($where){
                                case 'image':
                                    $tpl_upl.find('.progress-bar').attr('id','progressBarImage');
                                    break;
                                case 'voice':
                                    $tpl_upl.find('a').text('本地上传');
                                    $tpl_upl.find('.progress-bar').attr('id','progressBarVoice');
                                    break;
                                /*case 'music':
                                    $tpl_upl.find('.progress-bar').attr('id','progressBarThumb');
                                    break;
                                case 'video':
                                    $tpl_upl.find('.progress-bar').attr('id','progressBarVideo');
                                    break;
                                case 'news':
                                    $tpl_upl.find('a').text('新建图文').attr({
                                        'href':'/Home/PdMaterial/addNewsPage',
                                        'target':'_blank'
                                    });
                                    $tpl_upl.find('.progress').hide();
                                    break;*/
                            }
                            $('.tab-pane.active').empty();
                            $('.tab-pane.active').append($tpl_mat).find('[data-toggle=modal]').attr('href', '#modal-container-' + $where);
                            $('.tab-pane.active').append($tpl_upl);
                        });
                        progressBar.style.width = '0%';
                    }
                }
            }
        }
    })
}

//添加素材选择是素材框内容特效动作 ok
function add_select_animate(element) {
    $('.modal-content').find('.modal-body').find('[data-selected=selected]').attr('data-selected', '');
    $(element).siblings().css('opacity','0.5').attr('data-selected', '');
    $(element).css('opacity',"1.0").attr('data-selected', 'selected');
    $(element).parents('.modal-content').find('.modal-footer').find('[data-type=ensure]').removeClass('disabled');
    $(element).parents('.modal-content').find('.modal-footer').find('[data-type=thumb_ensure]').removeClass('disabled');
}

//图片缩放动画 ok
function image_scale_animate(img,scale) {
    $(img).css('transform','scale('+scale+','+scale+')');
}

//语音在线播放事件 ok
function voice_listen_online(ele) {
    $('#iframe').attr('src','/Home/PdMaterial/voiceDisplay?media_id='+$(ele).parents('.data_box_voice').attr('data-id'));
}

//获取数据回复数据
function get_data_from_tab_pane(){
    $responseType=$('.tab-pane.active').attr('id').substr(6);
    switch ($responseTypetype){
        case 'text':
            $data={'content':$('.tab-pane.active').find('textarea').val()};
            break;
        case 'image':
            $data={'media_id':$('.tab-pane.active').find('img').attr('data-id')};
            break;
        case 'voice':
            $data={'media_id':$('.tab-pane.active').find('.data_box_voice').attr('data-id')};
            break;
        case 'music':
            $data={
                'title':$('.tab-pane.active').find('[name="title"]').val(),
                'description':$('.tab-pane.active').find('[name="description"]').val(),
                'music_url':$('.tab-pane.active').find('[name="music_url"]').val(),
                'hq_music_url':$('.tab-pane.active').find('[name="hq_music_url"]').val(),
                'thumb_media_id':$('.tab-pane.active').find('img').attr('data-id')
            };
            break;
        case 'video':
            $data={
                'media_id':$('.tab-pane.active').find('.data_box_video').attr('data-id'),
                'title':$('.tab-pane.active').find('[name="title"]').text(),
                'description':''
            };
            console.log($data);
            break;
        case 'news':
            $data={'media_id':$('.tab-pane.active').find('.news_footer').attr('data-id')};
            break;
    }
    return $data;
}

//元素移除操作
function remove_event() {
    //更新素材选择区的状态
    $('.modal-content').find('[data-selected=selected]').attr('data-selected', '');
    $('.modal-content').find('.modal-footer').find('[data-type=ensure]').addClass('disabled');
    $('.modal-content').find('.modal-footer').find('[data-type=thumb_ensure]').addClass('disabled');
    //克隆模板
    $tpl_mat=$('[data-type=sel_mat_model]').clone().css('display', 'block').attr('data-type', '');
    $tpl_upl=$('[data-type=upload_model]').clone().css('display', 'block').attr('data-type', '');
    //修正进度条和链接操作
    $where=$('.tab-pane.active').attr('id').substr(6);
    switch ($where){
        case 'image':
            $tpl_upl.find('.progress-bar').attr('id','progressBarImage');
            break;
        case 'voice':
            $tpl_upl.find('.progress-bar').attr('id','progressBarVoice');
            break;
        case 'music':
            $tpl_upl.find('.progress-bar').attr('id','progressBarThumb');
            break;
        case 'video':
            $tpl_upl.find('a').text('本地上传').attr({
                'href':'#modal-add-video',
                'data-toggle':"modal",
                'onclick':null
            });
            $tpl_upl.find('.progress-bar').attr('id','progressBarVideo');
            break;
        case 'news':
            $tpl_upl.find('a').text('新建图文').attr({
                'href':'/Home/PdMaterial/addNewsPage',
                'target':'_blank'
            });
            $tpl_upl.find('.progress').hide();
            break;
        }
        $('.tab-pane.active').empty();
        $('.tab-pane.active').append($tpl_mat).find('[data-toggle=modal]').attr('href', '#modal-container-'+$where);
        $('.tab-pane.active').append($tpl_upl);
}

//删除规则处理 ok
function delete_rule(ele) {
    $(ele).addClass('ensure');
    $data = {
        'type': 'keyword',
        'rule': $(ele).parent().find('span').text()
    };
    $.post('delResponse', $data, function (data) {
        $('.delete_rule.ensure').parents('.cell').remove();
        alert(data);
    })
}
