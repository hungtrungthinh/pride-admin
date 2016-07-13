
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
			setHeader("No, Caption, Description");
			attachHeader("&nbsp;,#text_filter,#text_filter");
			setColumnIds(",caption,description");
			setInitWidths("45,220,*");
			setColAlign("center,left,left");
			setColTypes("cntr,ed,ed");
			init();
		}
	},
	
	initDataProcessor : function() {
		with (this.dhxDP = new dataProcessor("/claim/savedata")) {
			setTransactionMode("POST",true);
			setUpdateMode("off");
			enableDataNames(true);
			init(obj.dhxGrid);
		}
	},
	
	loadData : function () {
		with (this.dhxGrid) {
			clearAndLoad("/claim/getdata");
		}
	},
	
	addData : function () {				
		with(obj.dhxGrid) {
			addRow(uid(), ["", "", ""], getRowsNum());
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