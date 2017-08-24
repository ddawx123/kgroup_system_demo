// JavaScript Document
// Charset: UTF-8

/**
 * 页面全局JS入口，通过JQuery侦测页面状态
 * @version 2017.7.23.Release
 * @return mixed
 * @author alone◎浅忆
 * @copyright 2017 DingStudio All Rights Reserved
 */
$(document).ready(function() {
    //var background_id = parseInt(Math.random()*(9-1+1)+1);
	//var mainframe = document.getElementById("application");
    //mainframe.style.background="url(static/img/" + background_id + ".jpg)";
    initialization();
});

/**
 * 前端应用代码实现主体入口
 * @version 2017.8.3.V2
 * @return mixed
 * @author alone◎浅忆
 * @copyright 2017 DingStudio All Rights Reserved
 */
function initialization() {
    $("#loginbtn").click(function () {
        var username = document.getElementById("username").value;
        var locate = document.getElementById("locate").value;
        var qqnum = document.getElementById("qqnum").value;
        var like = document.getElementById("like").value;
        checkSubmit(username, locate, qqnum, like);
        return false;
    });
}

/**
 * 用户信息前端的检查与提交
 * @version 3.0
 * @param string username 用户帐号
 * @param string locate 地区
 * @param string qqnum QQ号
 * @param string like 个人爱好擅长点
 * @return mixed
 * @author alone◎浅忆
 * @copyright 2017 DingStudio All Rights Reserved
 */
function checkSubmit(username, locate, qqnum, like) {
    if (username == '' || locate == '' || qqnum == '' || like == '') {
        swal.queue([{
            title: '出错啦',
            confirmButtonText: '额，那我再看看',
            text: '请检查您是否完成了所有信息填写后再次尝试提交申请，如果填写完整后依旧显示此提示，请加技术QQ：954759397。',
            showConfirmButton: true,
            showCancelButton: false,
            type: 'error'
        }]);
    }
    else {
        swal.queue([{
            title: '确认信息正确性',
            confirmButtonText: '继续提交',
            cancelButtonText: '返回修改',
            text: '请确认您的信息填写正确，错误的信息将导致您无法加入家族哦！',
            showLoaderOnConfirm: true,
            showCancelButton: true,
            showConfirmButton: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        url: "ajax.php",
                        type: "post",
                        dataType: "json",
                        data: {
                            type: 'apply_usr',
                            cors_domain: window.location.protocol + '//' + window.location.host,
                            username: username,
                            locate: locate,
                            qqnum: qqnum,
                            like: like
                        },
                        async: true,
                        success: function (res) {
                            if (res.code === 200) {
                                swal.insertQueueStep("恭喜您，申请信息提交成功！管理人员将在一个工作日内完成审核，正在传送页面。请不要先关闭页面！");
                                setCookie('kgroup_applystatus',res.data.token,1);
                                var intervalid = setTimeout("Redirect('./qqgroup.php?action=callback')",2000);
                                resolve();
                            }
                            else if (res.code === 403) {
                                swal.insertQueueStep("抱歉，由于您所填写的QQ之前已被申请，本次提交已被系统自动拒绝！");
                                resolve();
                            }
                            else if (res.code === 502) {
                                swal.insertQueueStep("哎呀，服务器忙死了！请稍候再次尝试，如果此状况反复出现请联系管理员！");
                                resolve();
                            }
                            else if (res.code === 503) {
                                swal.insertQueueStep("无法连接数据库！请稍候再次尝试，如果此状况反复出现请联系管理员！");
                                resolve();
                            }
                            else {
                                swal.insertQueueStep("发生未知错误，请刷新页面后再次尝试！");
                                resolve();
                            }
                        },
                        error: function () {
                            swal.insertQueueStep("AJAX请求发生错误，远程服务器积极拒绝本次操作。请刷新页面后再次尝试！");
                            resolve();
                        }
                    });
                });
            }
        }]);
        return false;
    }
}

//Cookie Controller
/**
 * Cookie 的创建过程
 * @param string c_name cookie名
 * @param string value cookie值
 * @param string expiredays 过期时间
 * @return null
 */
function setCookie(c_name,value,expiredays) {
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + expiredays);
	document.cookie = c_name + "=" + escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString() + ";path=/");
}
/**
 * Cookie 的读取过程
 * @param string c_name cookie名
 * @return string
 */
function getCookie(cname) {
	if (document.cookie.length>0) {
		c_start=document.cookie.indexOf(cname + "=");
		if (c_start!=-1) {
			c_start=c_start + cname.length+1;
			c_end=document.cookie.indexOf(";",c_start);
			if (c_end==-1) {
				c_end=document.cookie.length;
			}
			return unescape(document.cookie.substring(c_start,c_end));
		}
	}
	return "";
}
/**
 * Cookie 的查验过程
 * @param string cookie_name cookie名
 * @return boolean
 */
function checkCookie(cookie_name) {
	username=getCookie(cookie_name);
	if (username!=null && username!="") {
		return true;
	}
	else {
		/*username=prompt('Please enter your name:',"");
		if (username!=null && username!="") {
			setCookie(cookie_name,username,365);
		}*/
		return false;
	}
}

function helpform() {
    window.open('help.htm','_blank','menubar=no,toolbar=no,status=yes,scrollbars=yes');
}

function Redirect(url) {
	document.location=url;
}

function indexDingStudio() {
    if(!confirm('确认继续？将跳转到技术人员官方网站。')) {
        return false;
    }
    else {
        return true;
    }
}