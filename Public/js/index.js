//导航栏开始
function showsumenu(li){
		var obj =li.getElementsByTagName("ul")[0];
		obj.style.display='block';
}
	function hiddenmenu(li){
		var obj =li.getElementsByTagName("ul")[0];
		obj.style.display='none';
}//导航栏结束

//轮播图开始
window.onload = function(){
    		var container = document.getElementById('container');
    		var list = document.getElementById('list');
    		var buttons = document.getElementById('buttons').getElementsByTagName('span');
    		var prev = document.getElementById('prev');
    		var next = document.getElementById('next');
    		var index = 1;
    		var animated = false;
    		var timer;

    		function showButton(){
    			for(var i = 0;i<buttons.length;i++){
    				if(buttons[i].className = 'on'){
    					buttons[i].className = '';
    				}
    			}
    			buttons[index-1].className = 'on';
    		}

    		function animate(offset){
    			animated = true;
    			var newLeft = parseInt(list.style.left) + offset;
    			var time = 500; //位移总时间
    			var interval = 10;//位移间隔时间
    			var speed = offset/(time/interval);//每次位移量

    			function go(){
    				if( (speed < 0 && parseInt(list.style.left) > newLeft) || (speed > 0 && parseInt(list.style.left) < newLeft) ){
    					list.style.left = parseInt(list.style.left) +speed +'px';
    					setTimeout(go,interval);
    				}else{
    					animated = false;
    					list.style.left = newLeft +'px';
		    			if( newLeft > -1000 ){
		    				list.style.left = -6000 +'px';
		    			}
		    			if( newLeft < -6000 ){
		    				list.style.left = -1000 +'px';
		    			}
    				}
    			}
    			go();	
    		}

    		function play(){
    				timer = setInterval( function(){
    				next.onclick();
    			} ,3000);
    		}

    		function stop_play(){
    			clearInterval(timer);
    		}

    		next.onclick = function(){
    			if(!animated){
    				if(index == 6){
    				index =1;
    			}
    			else{
    				index++;
    			}
    				showButton(index);
    				animate(-1000);
    			}
    			
    		}
    		prev.onclick = function(){
    			if(!animated){
    				if(index == 1){
    				index =6;
    			}
    			else{
    				index--;
    			}
    				showButton();
    				animate(1000);
    			}
    		}
    		for(var i=0;i < buttons.length;i++){
    			buttons[i].onclick = function(){
                    if(!animated){
                        if(this.className == 'on'){
                        return;
                    }
                    var myindex = parseInt(this.getAttribute('index'));
                    var offset = -1000*(myindex - index);
                    index = myindex;
                    if(!animated){
                        animate(offset);
                    }
                    showButton();
                    }
    				
    			}
    		}

    		container.onmouseover = stop_play;
    		container.onmouseout = play;
    		play();

 };//轮播图结束

