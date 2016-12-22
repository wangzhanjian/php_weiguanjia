$(function(){
    //替换编辑器
    CKEDITOR.replace( 'editor' );
    //将编辑器内容清空
    CKEDITOR.instances.editor.setData('');

    //创建全局数据缓存
    $data=new Object();
    $data['articles']=new Array();

    //如果是编辑素材则从页面获取数据
    if($('[data-where=modify]').length){
        $news=$('newsData').text();
        $data.articles=JSON.parse($news).news_item;
        $data.media_id=$('newsData').attr('data-id');
        $('newsData').remove();
        //显示已激活元素的数据
        $activeIndex=$('.news_body').find('.active').attr('data-index');
        if($curData=$data.articles[$activeIndex]){
            $('.news_body').find('.active').find('img').attr('data-id',$curData.thumb_media_id);
            $('.news_body').find('.active').find('img').attr('src','http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl='+$curData.thumb_url);
            $('.news_body').find('.active').find('h5').text($curData.title);
            $('[name=title]').val($curData.title);
            $('[name=author]').val($curData.author);
            $('[name=digest]').val($curData.digest);
            CKEDITOR.instances.editor.setData($curData.content);
            $('[name=content_source_url]').val($curData.content_source_url);
        }
        for($i=1;$i;$i+=1){
            if($data.articles[$i]){
                $ele=$('<div class="col-xs-12 column data_box" data-index="'+$i+'"><div class="col-xs-8 column"><h5>'+$data.articles[$i].title+'</h5></div><div class="col-xs-4 column"><img src="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl='+$data.articles[$i].thumb_url+'" width="100%" height="70px" data-id="'+$data.articles[$i].thumb_media_id+'"></div></div>');
                //为左边列表块元素添加新元素和动作特效
                add_active_and_ele_for_left_list();
                //将摘要隐藏
                $('[name=digest]').parent().parent().hide();
            }else{
                break;
            }
        }
    }else{
        //如果草稿箱有数据则从草稿箱获取
        if($draft=localStorage.news){
            $data=JSON.parse($draft);
            //显示已激活元素的数据
            $activeIndex=$('.news_body').find('.active').attr('data-index');
            if($curData=$data.articles[$activeIndex]){
                $('.news_body').find('.active').find('img').attr('data-id',$curData.thumb_media_id);
                $('.news_body').find('.active').find('img').attr('src','http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl='+$curData.thumb_url);
                $('.news_body').find('.active').find('h5').text($curData.title);
                $('[name=title]').val($curData.title);
                $('[name=author]').val($curData.author);
                $('[name=digest]').val($curData.digest);
                CKEDITOR.instances.editor.setData($curData.content);
                $('[name=content_source_url]').val($curData.content_source_url);
            }
            for($i=1;$i;$i+=1){
                if($data.articles[$i]){
                    $ele=$('<div class="col-xs-12 column data_box" data-index="'+$i+'"><div class="col-xs-8 column"><h5>'+$data.articles[$i].title+'</h5></div><div class="col-xs-4 column"><img src="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl='+$data.articles[$i].thumb_url+'" width="100%" height="70px" data-id="'+$data.articles[$i].thumb_media_id+'"></div></div>');
                    //为左边列表块元素添加新元素和动作特效
                    add_active_and_ele_for_left_list();
                    //将摘要隐藏
                    $('[name=digest]').parent().parent().hide();
                }else{
                    break;
                }
            }
        }
    }

    //添加图文消息图文栏（特效）
    $('[data-type=add_news]').click(function(){
        //获取图文栏图文的个数
        $count=$('.news_body').children().length;
        if($count<8){
            //添加子元素
            $ele=$('<div class="col-xs-12 column data_box" data-index="'+$count+'"><div class="col-xs-8 column"><h5>title</h5></div><div class="col-xs-4 column"><img src="" width="100%" height="70px"></div></div>');
            //为左边列表块元素添加新元素和动作特效
            add_active_and_ele_for_left_list();
            //将摘要隐藏
            $('[name=digest]').parent().parent().hide();
        }else{
            alert('每篇图文消息最多8条！');
        }
    });

    //删除图文消息图文栏(特效)
    $('[data-type=del_news]').click(function(){
        $count=$('.news_body').children().length;
        if($count>1){
            //获取当前元素的索引值
            $preIndex=$('.news_body').children(':last').attr('data-index');
            //如果被移除的是被选中的元素，将被选中的元素上移一个
            if($('.news_body').children(':last').attr('data-state')==1){
                //将上一个元素状态激活
                $('.news_body').find('[data-index='+($preIndex-1)+']').attr('data-state', '1').addClass('active');
                //删除最后一个元素
                $('.news_body').children(':last').remove();
                //如果删除后只剩一个元素则显示摘要
                if($('.news_body').children().length==1){
                    $('[name=digest]').parent().parent().show();
                }
                //如果被删除的元素数据不为空则清除该元素的数据缓存
                if($data.articles[$preIndex]){
                    delete $data.articles[$preIndex];
                }
            }else{
                //如果被删除的元素数据不为空则清除该元素的数据
                if($data.articles[$preIndex]){
                    delete $data.articles[$preIndex];
                }
                //移除最后一个元素
                $('.news_body').children(':last').remove();
                //如果删除后只剩一个元素则显示摘要
                if($('.news_body').children().length==1){
                    $('[name=digest]').parent().parent().show();
                }
            }
        }else{
            alert('没篇图文至少包含一条图文消息！');
        }
    });

    //保存为草稿
    $('#save_as_draft').click(function(){
        //获取当前激活元素的数据并保存到缓存
        get_active_data_and_save_to_buffer();
        //将缓存的数据解析会json后保存在本地
        localStorage.news=JSON.stringify($data);
        alert('保存成功！');
    });

    //获取素材库的素材
    $('[data-type=select_from_material]').click(function () {
        if(!$('.modal-body').find('.img_list').children().length){
            $offset=$('#modal-container-image').find('.img_list').children().length;
            $.get('getMaterialListAjax',{'type':'image','offset':$offset},function (data) {
                if(data=='error'){
                    alert('获取素材失败！');
                }else{
                    $imgs=JSON.parse(data);
                    $len=$imgs.item.length;
                    if($len){
                        for($i=0;$i<$len;$i+=1){
                            $ele='<div class="col-sm-3 column cell" data-type="data_box_cell"><div class="col-sm-12 column data_box_img"><img src="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl='+$imgs.item[$i].url+'" height="117" width="100%" data-id="'+$imgs.item[$i].media_id+'"/><p class="text-center">'+$imgs.item[$i].name.substr($imgs.item[$i].name.lastIndexOf('/')+1,15)+'</p></div></div>';
                            $('.modal-body').find('.img_list').append($ele);
                        }
                        //为新增的元素添加动作特效
                        add_select_active();
                        //判断是否显示加载更多操作
                        if($len==20){
                            $('.load_more').removeClass('hidden');
                        }else{
                            $('.load_more').addClass('hidden');
                        }
                    }else{
                        alert('您还没有素材！');
                    }
                }
            });
        }
    });

    //加载更多图片素材处理
    $('.load_more').click(function () {
        $offset=$('#modal-container-image').find('.img_list').children().length;
        $.get('getMaterialListAjax',{'type':'image','offset':$offset},function (data) {
            if(data=='error'){
                alert('获取素材失败！');
            }else{
                $imgs=JSON.parse(data);
                $len=$imgs.item.length;
                if($len){
                    for($i=0;$i<$len;$i+=1){
                        $ele='<div class="col-sm-3 column cell" data-type="data_box_cell"><div class="col-sm-12 column data_box_img"><img src="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl='+$imgs.item[$i].url+'" height="117" width="100%" data-id="'+$imgs.item[$i].media_id+'"/><p class="text-center">'+$imgs.item[$i].name.substr($imgs.item[$i].name.lastIndexOf('/')+1,15)+'</p></div></div>';
                        $('.modal-body').find('.img_list').append($ele);
                    }
                    //为新增的元素添加动作特效
                    add_select_active();
                    //判断是否显示加载更多
                    if($len==20){
                        $('.load_more').removeClass('hidden');
                    }else{
                        $('.load_more').addClass('hidden');
                    }
                }else{
                    alert('无更多素材！');
                }
            }
        });
    });

    //更新图文列表栏的标题
    $('[name=title]').change(function(){
        $('.news_body').find('.active').find('h5').text($(this).val());
    });

    //本地上传封面图片处理
    $('[data-type=upload_thumb]').click(function(){
        $('#thumb_file').click();
        $('#thumb_file').change(function(){
            if($(this).val().length){
                var xhr = new XMLHttpRequest();
                var filesObj = document.getElementById('thumb_file').files[0];
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
                            $('.news_body').find('.active').find('img').attr({
                                'src': 'http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl='+$json.url,
                                'data-id': $json.media_id
                            });
                            alert('上传成功！');
                        }
                    }
                }
            }
        })
        return false;
    });

    //保存图文处理
    $('#save').click(function(){
        $(this).text('保存中...').addClass('disabled');
        //获取当前激活元素的数据并保存到缓存
        get_active_data_and_save_to_buffer();
        $.post('addNewsAjax',$data,function(data){
            if(data=='error'){
                alert('保存失败！');
            }else{
                alert('保存成功！');
                localStorage.removeItem('news');
                window.location.href='addNewsPage';
            }
        })
    });

    //关闭编辑窗口
    $('#close_edit').click(function () {
        window.location.href='newsList';
    });
    
    //更新图文消息
    $('#update_news').click(function () {
        $(this).text('保存中...').addClass('disabled');
        //获取当前激活元素的数据并保存到缓存
        get_active_data_and_save_to_buffer();
        $.post('updateNewsAjax',$data,function (data) {
            if(data=='successsuccess'){
                alert('保存成功！');
                window.location.href='newsList';
            }else{
                alert('保存失败！');
                $('#update_news.disabled').text('保 存').removeClass('disabled');
            }
        })
    });
    
    //测试使用
    /*$('#save_news').click(function(){
     var data = CKEDITOR.instances.editor.getData();
     console.log(data);
     CKEDITOR.instances.editor.insertText( ' line1 \n\n line2' );
     });*/
})

//添加素材选择是素材框内容特效动作
function add_select_active() {
    //素材选择处理
    $('.modal-content').find('[data-type=data_box_cell]').click(function(){
        $('.modal-content').find('[data-selected=selected]').attr('data-selected','');
        $(this).siblings().css('opacity','0.5').attr('data-selected', '');
        $(this).css('opacity',"1.0");
        $(this).attr('data-selected', 'selected');
        $('.modal-content').find('.modal-footer').find('[data-type=ensure]').removeClass('disabled');
        $('.modal-content').find('.modal-footer').find('[data-type=thumb_ensure]').removeClass('disabled');
    });
    //选择素材后界面元素更新
    $('.modal-content').find('.modal-footer').find('[data-type=ensure]').click(function(){
        //获取被选中元素的src
        $thumb_url=$('.modal-content').find('[data-selected=selected]').find('img').attr('src');
        $media_id=$('.modal-content').find('[data-selected=selected]').find('img').attr('data-id');
        //给图文添加封面及数据
        $('.news_body').find('.active').find('img').attr({
            'src': $thumb_url,
            'data-id': $media_id
        });
        //关闭弹出的界面
        $(this).attr('data-dismiss', 'modal');
    });
}

//为左边列表块元素添加新元素和动作特效
function add_active_and_ele_for_left_list() {
    $('.news_body').append($ele).find('.data_box').click(function(){
        //如果激活的不是已激活的元素
        if(!$(this).attr('data-state') || $(this).attr('data-state')==0){
            //获取前一个元素的数据并保存至本地
            //取得上一个元素的索引值
            $preIndex=$('.news_body').find('.data_box.active').attr('data-index');
            //获取上一个元素的图文数据
            $preData={
                'title':$('[name=title]').val(),
                'thumb_media_id': $('.news_body').find('.active').find('img').attr('data-id'),
                'author':$('[name=author]').val(),
                'digest':$('[name=digest]').val(),
                "show_cover_pic": 0,
                'content':CKEDITOR.instances.editor.getData(),
                'content_source_url':$('[name=content_source_url]').val(),
                'thumb_url':$('.news_body').find('.active').find('img').attr('src').substr($('.news_body').find('.active').find('img').attr('src').indexOf('Url=')+4)
            };
            //将数据添加至数据缓存
            $data.articles[$preIndex]=$preData;

            //改变当前元素的样式使其为激活状态
            $(this).addClass('active').attr('data-state','1');
            $(this).siblings().removeClass('active').attr('data-state','0');

            //如果当前元素有本地数据将数据反提到编辑区
            //获取当前元素的索引值
            $curIndex=$(this).attr('data-index');

            if($curData=$data.articles[$curIndex]){      //如果存在缓存数据
                $('.news_body').find('.active').find('img').attr('data-id',$curData.thumb_media_id);
                $('.news_body').find('.active').find('img').attr('src','http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl='+$curData.thumb_url);
                $('[name=title]').val($curData.title);
                $('[name=author]').val($curData.author);
                $('[name=digest]').val($curData.digest);
                CKEDITOR.instances.editor.setData($curData.content);
                $('[name=content_source_url]').val($curData.content_source_url);
            }else{
                $('[name=title]').val('');
                $('[name=author]').val('');
                $('[name=digest]').val('');
                CKEDITOR.instances.editor.setData('');
                $('[name=content_source_url]').val('');
                $('.news_body').find('.active').find('img').attr('data-id','');
                $('.news_body').find('.active').find('img').attr('src','');
            }
        }
    });
}

//获取当前激活元素的数据并保存到缓存
function get_active_data_and_save_to_buffer() {
    //获取当前编辑元素的内容并保存至本地
    //获取当前被激活元素的索引
    $curIndex=$('.news_body').find('.data_box.active').attr('data-index');
    //获取当前元素的图文数据
    $curData={
        'title':$('[name=title]').val(),
        'thumb_media_id': $('.news_body').find('.active').find('img').attr('data-id'),
        'author':$('[name=author]').val(),
        'digest':$('[name=digest]').val(),
        "show_cover_pic": 0,
        'content': CKEDITOR.instances.editor.getData(),
        'content_source_url':$('[name=content_source_url]').val(),
        'thumb_url':$('.news_body').find('.active').find('img').attr('src').substr($('.news_body').find('.active').find('img').attr('src').indexOf('Url=')+4)
    };
    //将数据添加至数据缓存
    $data.articles[$curIndex]=$curData;
}