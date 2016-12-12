function uploadFile(url,file,data,progress) {
    var xhr = new XMLHttpRequest();
    var filesObj = document.getElementById(file).files[0];
    var formData = new FormData();
    formData.append('data',data);
    formData.append('files', filesObj);
    xhr.open("POST", url, true);
    //设定下载progress事件的处理函数，该事件在数据下载时触发
    xhr.onprogress = updateProgress;
    //设定上传progress事件的处理函数，该事件在数据上传时触发
    xhr.upload.onprogress = updateProgress;
    var progressBar = document.getElementById(progress);
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
            /*progressBar.style.width = '0%';
            return xhr.responseText;*/
            uploadCallback(xhr.responseText,filesObj);
        }
    }
}