
var obj;

var JSStandard = function() {
	this.dhxToolBar = null;
	this.dhxGrid = null;
	this.dhxDP = null;
};
JSStandard.prototype = {
	init : function () {
		this.initToolbar();
		this.initGrid();
		this.initDataProcessor();
		this.loadData();
	},
	
	initToolbar: function () {
		with (this.dhxToolBar = new dhtmlXToolbarObject("toolbar")) {
			setIconsPath("/assets/images/buttons/");
			setSkin("dhx_terrace");
			addText("left", 1, "&#160;&#160;&#160;&#160;");
			addSpacer("left");
			addButton("btnAdd", 2, "Add", "add.png");
			addText("", 3, "&#160;&#160;");
			addButton("btnRemove", 4, "Remove", "remove.png");
			addText("", 5, "&#160;&#160;");
			addButton("btnSave", 6, "Save", "save.png");
			addText("", 7, "&#160;&#160;&#160;&#160;");
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

	},
	
	initGrid: function () {
		with (this.dhxGrid = new dhtmlXGridObject('gridbox')) {
			setImagePath("/assets/libs/dhx/skins/terrace/imgs/dhxgrid_terrace/");
			setSkin("dhx_web");
			setHeader("No, User ID, Password, User Name, Regist Date, Allow, Access Count");
			setColumnIds(",user_id,user_pass,full_name,reg_date,allow,access_count");
			setInitWidths("45,154,154, 200, 0, 72, 128");
			setColTypes("cntr,ed,ed,ed,dhxCalendarA,coro,ro");
			setColAlign("center,left,left,left,center,center,right");
			setDateFormat("%Y-%m-%d %H:%i");
			init();
			getCombo(5).put(0, 0);
			getCombo(5).put(1, 1);
			getCombo(5).put(2, 2);
		}
	},
	
	initDataProcessor : function() {
		with (this.dhxDP = new dataProcessor("/user/saveusers")) {
			setTransactionMode("POST",true);
			setUpdateMode("off");
			enableDataNames(true);
			init(obj.dhxGrid);
		}
	},
	
	loadData : function () {
		with (this.dhxGrid) {
			clearAndLoad("/user/getregistedusers");
		}
	},
	
	addData : function () {				
		with(obj.dhxGrid) {
			addRow(uid(), ["", "", "","",new Date(),"0",""], getRowsNum());
		}
	},
	
	removeData : function () {
		if (obj.dhxGrid.getSelectedRowId() != null) {
			this.dhxGrid.deleteRow(obj.dhxGrid.getSelectedRowId());
		}
	},
	
	saveData : function () {
		obj.dhxDP.sendData();
	}
}
$(window).ready(function() {
	obj = new JSStandard();
	obj.init();
});