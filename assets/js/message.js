
var obj;

var JSStandard = function() {
	this.dhxToolBar = null;
	this.dhxGrid = null;
	this.dhxWindow = null;
	this.dhxDP = null;
	this.dateFrom;
	this.dateTo;
};
JSStandard.prototype = {
	init : function () {
		this.initToolbar();
		this.initGrid();
		this.initDataProcessor();
		this.loadData();
	},
	
	initToolbar: function () {
		var date = new Date();
		var today = date.getFullYear() + ' - ' + ((date.getMonth() + 1) > 9 ? (date.getMonth() + 1) : '0' + (date.getMonth() + 1)) + ' - ' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate()));
		with (this.dhxToolBar = new dhtmlXToolbarObject("toolbar")) {
			setIconsPath("/assets/images/buttons/");
			addText("", 0, "From:&#160;&#160;<input type='text' id='from' style='width:112px;text-align:center;' value='" + today + "' readonly/>");
			addText("", 1, "&#160;&#160;&#160;&#160;");
			addText("", 2, "To:&#160;&#160;<input type='text' id='to' style='width:112px;text-align:center;' value='" + today + "' readonly/>");
			addText("left", 3, "&#160;&#160;&#160;&#160;");
			addSpacer("left");
			addButton("btnAdd", 4, "Add", "add.png");
			addText("", 5, "&#160;&#160;");
			addButton("btnRemove", 6, "Remove", "remove.png");
			addText("", 7, "&#160;&#160;");
			addButton("btnSave", 8, "Save", "save.png");
			addText("", 9, "&#160;&#160;&#160;&#160;");
			setSkin("dhx_terrace");
			attachEvent("onClick", function(id) {
				switch(id) {
					case "btnAdd":
						obj.addData();
						break;
					case "btnRemove":
						obj.removeData();
						break;
					case "btnSave":
						obj.saveData();
						break;
					default:
						break;
				}
			});	
		}
		with (obj.dateFrom = new dhtmlXCalendarObject("from")) {
			setDateFormat("%Y - %m - %d");
			attachEvent("onClick", function(date, state){
				obj.loadData();
				return true;
			});
		}
		with (obj.dateTo = new dhtmlXCalendarObject("to")) {
			setDateFormat("%Y - %m - %d");
			attachEvent("onClick", function(date, state){
				obj.loadData();
				return true;
			});
		}

	},
	
	initGrid: function () {
		with (this.dhxGrid = new dhtmlXGridObject('gridbox')) {
			setImagePath("/assets/libs/dhx/skins/terrace/imgs/dhxgrid_terrace/");
			setHeader("No, Request Time, Content, Name, Phone Number, Email, Claim Type");
			setColumnIds(",request_time,message,full_name,phone_number,email,claim_id");
			setInitWidths("45,180,*,144,122,200, 120");
			setColAlign("left,center,left,left,left");
			setColTypes("cntr,dhxCalendar,txt,ed,ed,ed,coro");
			setColSorting("int,date,str,str,str,str,str");
			setDateFormat("%Y-%m-%d %H:%i");
			$.getJSON("/claim/getclaimjson", function(response) {
				for (var i=0; i<response.length; i++) {
					getCombo(6).put(response[i].id, response[i].caption);
				}
			});
			init();
		}
	},
	
	initDataProcessor : function() {
		with (this.dhxDP = new dataProcessor("/message/updatemessages")) {
			setTransactionMode("POST",true);
			setUpdateMode("off");
			enableDataNames(true);
			init(obj.dhxGrid);
		}
	},
	
	loadData : function () {
		with (this.dhxGrid) {
			clearAndLoad("/message/getdata?dateFrom=" + (this.dateFrom.getFormatedDate("%Y-%m-%d")) + "&dateTo=" + (this.dateTo.getFormatedDate("%Y-%m-%d")));
		}
		
	},
	
	addData : function () {
		with(obj.dhxGrid) {
			addRow(uid(), ["", new Date(), "", "", "", "", ,"","0"], getRowsNum());
		}
	},
	
	removeData : function () {
		this.dhxGrid.deleteRow(this.dhxGrid.getSelectedRowId());
	},
	
	saveData : function () {
		obj.dhxDP.sendData();
	}
}

$(window).ready(function() {
	obj = new JSStandard();
	obj.init();
});