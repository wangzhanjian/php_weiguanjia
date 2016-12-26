$(function () {
    //检查是否要显示加载更多
    if($('#news_list').length){
        check_load_more('#news_list');    // 图文
    }else if($('#image_list').length){
        check_load_more('#image_list');     //图片
    }else if($('#voice_list').length){
        check_load_more('#voice_list')      //语音
    }else if($('tbody').length){
        check_load_more('tbody');
    }

    $('#img_file').change(function(){
        if($(this).val().length){
            var xhr = new XMLHttpRequest();
            var filesObj = document.getElementById('img_file').files[0];
            var formData = new FormData();
            formData.append('files', filesObj);
            xhr.open("POST", 'addImage', true);
            //设定下载progress事件的处理函数，该事件在数据下载时触发
            xhr.onprogress = updateProgress;
            //设定上传progress事件的处理函数，该事件在数据上传时触发
            xhr.upload.onprogress = updateProgress;
            var progressBar = document.getElementById('progressBar');
            function updateProgress(event){
                //判断服务器是否提供数据长度信息
                if(event.lengthComputable){
                    //计算得到进度数值
                    var percentComplete = event.loaded/event.total;
                    //在控制台记录进度数值
                    //console.log(percentComplete);
                    progressBar.style.width = percentComplete*100+'%';
                }
            }
            xhr.send(formData);
            xhr.onreadystatechange = function(){
                if(xhr.readyState==4 && xhr.status==200){
                    $result= xhr.responseText;
                    if($result=='error'){
                        $('#progressBar').css('width','0%');
                        alert('上传失败！');
                    }else{
                        $('#progressBar').css('width','0%');
                        $json=JSON.parse($result);
                        $ele='<div class="col-xs-3 column cell"> <div class="col-xs-12 column image_box"> <img src="openImage?url='+$json.url+'" data-id="'+$json.media_id+'" width="100%" height="120px"> <p>'+filesObj.name.substr(0,15)+'</p> <button class="btn btn-default btn-block" data-type="image_del"><span class="glyphicon glyphicon-remove"></span></button> </div> </div>';
                        $('#image_list').prepend($ele);
                        image_del_event();
                    }
                }
            }
        }
    })

    $('#voice_file').change(function () {
        if($(this).val().length){
            var xhr = new XMLHttpRequest();
            var filesObj = document.getElementById('voice_file').files[0];
            var formData = new FormData();
            formData.append('files', filesObj);
            xhr.open("POST", 'addVoice', true);
            //设定下载progress事件的处理函数，该事件在数据下载时触发
            xhr.onprogress = updateProgress;
            //设定上传progress事件的处理函数，该事件在数据上传时触发
            xhr.upload.onprogress = updateProgress;
            var progressBar = document.getElementById('progressBar');
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
                    if($result=='error'){
                        $('#progressBar').css('width','0%');
                        alert('上传失败！');
                    }else{
                        $time=new Date();
                        $json=JSON.parse($result);
                        $ele='<div class="col-xs-4 column cell"> <div class="col-xs-12 column voice_box" data-id="'+$json.media_id+'"> <div class="col-xs-4 column"> <img src="getVoiceDisplayImg" width="100%" height="70"/> </div> <div class="col-xs-8 column"> <p>'+filesObj.name.substr(0,15)+'</p> <p>'+$time.getFullYear()+'年'+($time.getMonth()+1)+'月'+$time.getDate()+'日'+'</p> </div> <button class="btn btn-default btn-sm"><span class="glyphicon glyphicon-download-alt"></span></button><button class="btn btn-default btn-sm" data-type="voice_del"><span class="glyphicon glyphicon-remove"></span></button> </div> </div>';
                        $('#voice_list').prepend($ele);
                        voice_del_event();      //添加删除事件
                        voice_download_event(); //添加下载事件
                        voice_listen_online_animate(); //添加在线播放动画
                        voice_listen_online();      //绑定在线播放事件
                        $('#progressBar').css('width','0%');
                        alert('上传成功！');
                    }
                }
            }
        }
    });

    //图文消息删除操作
    news_del_event();

    //上传图片处理 ok
    $('#img_upload').click(function(){
        $('#img_file').click();
    });

    //删除图片操作 ok
    image_del_event();

    //上传语音发送操作 ok
    $('#voice_upload').click(function () {
        $('#voice_file').click();
    });

    //删除语音操作 ok
    voice_del_event();

    //下载语音素材操作 ok
   voice_download_event();

    //在线播放图标动作 ok
   voice_listen_online_animate();

    //在线播放操作 ok
    voice_listen_online();

    //上传视频操作
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
            xhr.open("POST", 'addVideo', true);
            //设定下载progress事件的处理函数，该事件在数据下载时触发
            xhr.onprogress = updateProgress;
            //设定上传progress事件的处理函数，该事件在数据上传时触发
            xhr.upload.onprogress = updateProgress;
            var progressBar = document.getElementById('progressBar');
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
                        $time=new Date();
                        $json=JSON.parse($result);
                        $ele='<tr> <td style="width:200px;height:100px;"> <video src="movie.ogg" width="150" hieght="100">Your browser does not support the video tag. </video> </td> <td>'+$('#title').val().substr(0,15)+'</td> <td>'+$time.getFullYear()+'年'+($time.getMonth()+1)+'月'+$time.getDate()+' </td> <td data-id="'+$json.media_id+'"> <button class="btn btn-default btn-sm" data-type="video_download"> <span class="glyphicon glyphicon-download-alt"></span></button><button class="btn btn-default btn-sm" data-type="video_del"><span class="glyphicon glyphicon-remove"></span></button> </td> </tr>';
                        $('tbody').prepend($ele);
                        video_del_event();  //为新添加的元素添加删除事件
                        alert('上传成功！');
                    }
                }
            }
        }
    });

    //删除视频操作
    video_del_event();

    //视频下载
    /*$('[data-type=video_download]').click(function () {
        $.post('downloadVideo',{"media_id":$(this).parent().attr('data-id')},function (data) {
            if(data=='failure'){
                console.log(data);
            }else{
                console.log(data);
                $json=JSON.parse(data);
                console.log($json);
                $('#iframe').attr('src',$json.down_url);
            }
        })
    });*/

    //加载更多素材
    $('.load_more').click(function () {
        $type=$(this).attr('data-load');
        $offset=$(this).parent().children().length-1;
        switch ($type){
            case 'news':
                $.get('getMaterialListAjax',{'type':'news','offset':$offset},function (data) {
                    if(data=='error'){
                        alert('加载失败！');
                    }else{
                        $list=JSON.parse(data);
                        $len=$list.item.length;
                        if($len){
                            for($i=0;$i<$len;$i+=1){
                                if($list.item[$i].content.news_item[1]){    //多图文素材
                                    $date=new Date($list.item[$i].update_time*1000);
                                    $ele=$('<div class="col-xs-4 column cell"><div class="col-xs-12 column news_box"><div class="news_header_more"> <h5>'+ $date.getFullYear()+'年'+$date.getMonth()+'月'+$date.getDate()+'日'+'</h5></div><div class="col-xs-12 column news_body"></div><div class="col-xs-12 column news_footer" data-id="'+$list.item[$i].media_id+'"><button class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span></button><button class="btn btn-default btn-sm" data-type="news_del"><span class="glyphicon glyphicon-remove"></span></button></div></div></div>');
                                    $childLen=$list.item[$i].content.news_item.length;
                                    for($k=0;$k<$childLen;$k+=1){
                                        if($k==0){
                                            $childEle='<a href="'+$list.item[$i].content.news_item[$k].url+'" target="_blank"><div class="first data_box"><img src="openImage?url='+auto_thumb_url($list.item[$i].content.news_item[$k].thumb_url)+'" width="100%" height="120px"> <h5 class="sm">'+$list.item[$i].content.news_item[$k].title.substr(0,15)+'</h5></div></a>';
                                            $ele.find('.news_body').append($childEle);
                                        }else{
                                            $childEle='<a href="'+$list.item[$i].content.news_item[$k].url+'" target="_blank"><div class="col-xs-12 column data_box"><div class="col-xs-8 column"><h5>'+$list.item[$i].content.news_item[$k].title.substr(0,15)+'</h5></div><div class="col-xs-4 column"><img width="100%" height="70" src="openImage?url='+auto_thumb_url($list.item[$i].content.news_item[$k].thumb_url)+'"></div></div></a>'
                                            $ele.find('.news_body').append($childEle);
                                        }
                                    }
                                }else{  //单图文素材
                                    $date=new Date($list.item[$i].update_time*1000);
                                    $ele='<a href="'+$list.item[$i].content.news_item[0].url+'" target="_blank"><div class="col-xs-4 column cell"><div class="col-xs-12 column news_box"><div class="news_header_single"><h5>'+ $date.getFullYear()+'年'+$date.getMonth()+'月'+$date.getDate()+'日'+'</h5></div> <div class="col-xs-12 column news_body"> <div class="col-xs-12 column data_box"> <p>'+$list.item[$i].content.news_item[0].title.substr(0,15)+'</p><img src="openImage?url='+auto_thumb_url($list.item[$i].content.news_item[0].thumb_url)+'" width="100%" height="150px"><p>'+$list.item[$i].content.news_item[0].digest+'</p></div></div><div class="col-xs-12 column news_footer" data-id="'+$list.item[$i].media_id+'"><button class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span></button><button class="btn btn-default btn-sm" data-type="news_del"><span class="glyphicon glyphicon-remove"></span></button></div></div></div></a>';
                                }
                                $('#news_list').append($ele);
                            }
                            news_del_event();     //为新增的图文添加删除事件
                            check_load_more('#news_list');
                            function auto_thumb_url(json) {
                                if(json){
                                    return json;
                                }else{
                                    return '';
                                }
                            }
                        }else{
                            alert('已无更多素材!');
                            $('.load_more').addClass('hidden');
                        }
                    }
                })
                break;
            case 'image':   //ok
                $.get('getMaterialListAjax',{'type':'image','offset':$offset},function (data) {
                    if(data=='error'){
                        alert('加载失败！');
                    }else{
                        $list=JSON.parse(data);
                        $len=$list.item.length;
                        if($len){
                            for($i=0;$i<$len;$i+=1){
                                $ele='<div class="col-xs-3 column cell"> <div class="col-xs-12 column image_box"> <img src="openImage?url='+$list.item[$i].url+'" data-id="'+$list.item[$i].media_id+'" width="100%" height="120px"> <p>'+$list.item[$i].name.substr($list.item[$i].name.lastIndexOf('/')+1,15)+'</p> <button class="btn btn-default btn-block" data-type="image_del"><span class="glyphicon glyphicon-remove"></span></button> </div> </div>';
                                $('#image_list').append($ele);
                            }
                            image_del_event();
                            check_load_more('#image_list');
                        }else{
                            alert('已无更多素材!');
                            $('.load_more').addClass('hidden');
                        }
                    }
                })
                break;
            case 'voice':   //ok
                $.get('getMaterialListAjax',{'type':'voice','offset':$offset},function (data) {
                    if(data=='error'){
                        console.log(data);
                        alert('加载失败！');
                    }else{
                        $list=JSON.parse(data);
                        $len=$list.item.length;
                        if($len){
                            for($i=0;$i<$len;$i+=1){
                                $date=new Date($list.item[$i].update_time*1000);
                                $ele='<div class="col-xs-4 column cell"><div class="col-xs-12 column voice_box" data-id="'+$list.item[$i].media_id+'"><div class="col-xs-4 column"><img src="getVoiceDisplayImg" alt="点击播放" title="点击播放" width="100%" height="70"/> </div> <div class="col-xs-8 column"><p data-type="file_name"></p>'+$list.item[$i].name.substr($list.item[$i].name.lastIndexOf('/')+1,15)+'<p>'+$date.getFullYear()+'年'+$date.getMonth()+'月'+$date.getDate()+'日'+'</p></div><button class="btn btn-default btn-sm" data-type="voice_download"><span class="glyphicon glyphicon-download-alt"></span></button><button class="btn btn-default btn-sm" data-type="voice_del"><span class="glyphicon glyphicon-remove"></span></button></div></div>';
                                $('#voice_list').append($ele);
                            }
                            //删除语音操作 ok
                            voice_del_event();
                            //下载语音素材操作 ok
                            voice_download_event();
                            //在线播放图标动作 ok
                            voice_listen_online_animate();
                            //在线播放操作 ok
                            voice_listen_online();
                            check_load_more('#voice_list');
                        }else{
                            alert('已无更多素材!');
                            $('.load_more').addClass('hidden');
                        }
                    }
                })
                break;
            case 'video':
                $videoOffset=$(this).parents('table').children('tbody').children().length;
                console.log($videoOffset);
                $.get('getMaterialListAjax',{'type':'video','offset':$offset},function (data) {
                    if(data=='error'){
                        console.log(data);
                        alert('加载失败！');
                    }else{
                        $list=JSON.parse(data);
                        $len=$list.item.length;
                        if($len){
                            for($i=0;$i<$len;$i+=1){
                                $date=new Date($list.item[$i].update_time*1000);
                                $ele='<tr><td style="width:200px;height:100px;"><video src="movie.ogg" width="150" hieght="100">Your browser does not support the video tag.</video></td><td>'+$list.item[$i].name.substr(0,15)+'</td><td>'+$date.getFullYear()+'年'+$date.getMonth()+'月'+$date.getDate()+'日'+'</td> <td data-id="'+$list.item[$i].media_id+'"><button class="btn btn-default btn-sm" data-type="video_download"><span class="glyphicon glyphicon-download-alt"></span></button><button class="btn btn-default btn-sm" data-type="video_del"><span class="glyphicon glyphicon-remove"></span></button></td></tr>';
                                $('table').children('tbody').append($ele);
                            }
                            video_del_event();
                            check_load_more('tbody');
                        }else{
                            alert('已无更多素材!');
                            $('.load_more').addClass('hidden');
                        }
                    }
                })
                break;
        }
    });

})

//控制加载更多连接的显示
function check_load_more(ele) {
    if(ele=='tbody'){        // 视频表格
        $childNum=$(ele.toString()).children().length;
    }else{                  //其它列表
        $childNum=$(ele.toString()).children().length-1;
    }
    console.log($(ele));
    console.log($childNum);
    if($childNum>=20 && $childNum%20==0){
        $('.load_more').removeClass('hidden');
    }else{
        $('.load_more').addClass('hidden');
    }
}

//图文消息添加删除事件
function news_del_event() {
    $('[data-type=news_del]').click(function () {
        $(this).addClass('active');
        $del=$.post('delete',{"media_id":$(this).parent().attr('data-id')},function (data) {
            if(data == 'error'){
                alert('删除失败！');
                $('[data-type=news_del].active').removeClass('active');
            }else{
                $('[data-type=news_del].active').parents('.cell').remove();
                alert('删除成功！');
            }
        });
    });
}

//为图片列表的图片添加删除事件 ok
function image_del_event() {
    $('[data-type=image_del]').click(function () {
        $(this).addClass('active');
        $.post('delete',{"media_id":$(this).siblings('img').attr('data-id')},function (data) {
            if(data=='success'){
                $('[data-type=image_del].active').parent().parent().remove();
                alert('删除成功！');
            }else{
                $('[data-type=image_del].active').removeClass('active');
                alert('删除失败！');
            }
        });
    });
}

//为语音列表的语音添加删除事件
function voice_del_event() {
    $('[data-type=voice_del]').click(function () {
        $(this).addClass('active');
        $.post('delete',{"media_id":$(this).parent().attr('data-id')},function (data) {
            if(data=='success'){
                $('[data-type=voice_del].active').parent().parent().remove();
                alert('删除成功！');
            }else{
                $('[data-type=voice_del].active').removeClass('active');
                alert('删除失败！');
            }
        });
    });
}

//语音下载事件
function voice_download_event() {
    $('[data-type=voice_download]').click(function () {
        $title=$(this).siblings().find('p[data-type=file_name]').text();
        $('#iframe').attr('src','downloadVoice?media_id='+$(this).parent().attr('data-id')+'&file_name='+$title);
    });
}

//语音在线播放图标动画
function voice_listen_online_animate() {
    $('.voice_box').find('img').mouseenter(function () {
        $(this).css('transform','scale(1.1,1.1)');
    });
    $('.voice_box').find('img').mouseleave(function () {
        $(this).css('transform','scale(1,1)');
    });
}

//语音在线播放事件
function voice_listen_online() {
    $('.voice_box').find('img').click(function () {
        $('#iframe').attr('src','voiceDisplay?media_id='+$(this).parents('.voice_box').attr('data-id'));
    });
}

//删除视频事件
function video_del_event() {
    $('[data-type=video_del]').click(function () {
        $(this).addClass('active');
        $.post('delete',{"media_id":$(this).parent().attr('data-id')},function (data) {
            if(data=='success'){
                $('[data-type=video_del].active').parent().parent().remove();
                alert('删除成功！');
            }else{
                $('[data-type=video_del].active').removeClass('active');
                alert('删除失败！');
            }
        });
    });
}