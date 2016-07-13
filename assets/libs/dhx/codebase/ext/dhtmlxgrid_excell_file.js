function eXcell_file(cell){
	if (cell){
		this.cell=cell;
		this.grid=this.cell.parentNode.grid;
	}
	this.edit=function(){
		this.cell.atag="INPUT";
		this.val=this.getValue();
		this.obj=document.createElement(this.cell.atag);
		this.obj.setAttribute("type", "file");
		this.obj.style.height=(this.cell.offsetHeight-(_isIE ? 4 : 4))+"px";
		this.obj.style.textAlign=this.cell.style.textAlign;
		this.obj.onclick=function(e){
			(e||event).cancelBubble=true
		}
		this.obj.onmousedown=function(e){
			(e||event).cancelBubble=true
		}
		this.obj.value=this.val
		this.cell.innerHTML="";
		this.cell.appendChild(this.obj);

		if (_isFF && !window._KHTMLrv){
			this.obj.style.overflow="visible";
		}
		this.obj.onselectstart=function(e){
			if (!e)
				e=event;
			e.cancelBubble=true;
			return true;
		};
		if (_isIE)
			this.obj.focus();
		this.obj.focus()
	}

	this.getValue=function(){
		if ((this.cell.firstChild)&&((this.cell.atag)&&(this.cell.firstChild.tagName == this.cell.atag)))
			return this.cell.value;

		if (this.cell._clearCell)
			return "";

		return this.cell.innerHTML.toString()._dhx_trim();
	}
	this.detach=function(){
		//Uncomment the following line to store the full path and filename as returned by the browser
		//this.setValue(this.obj.value);
		this.setValue(this.obj.value.replace(/(c:\\)*fakepath\\/i, ''));
		return this.val != this.getValue();
	}
}
eXcell_file.prototype=new eXcell;