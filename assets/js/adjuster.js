var obj, uploadForm, uploadedImage = null;
	
var JSStandard = function() {
	this.dhxToolBar = null;
	this.dhxGrid = null;
	this.dhxWins = null;
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
			setHeader("No, Name, Gender, Birthday, Address, Geolocation, Phone, Email, Avator");
			attachHeader("&nbsp;,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,&nbsp;");
			setColumnIds(",full_name,gender,birthday,address,geolocation,phone_number,email,avator");
			setInitWidths("45,180,72,92,*,160,112,220,200");
			setColAlign("center,center,left,left,left");
			setColTypes("cntr,ed,coro,dhxCalendar,ed,ed,ed,ed,ro");
			init();
			getCombo(2).put(0, "Male");
			getCombo(2).put(1, "Female");
		}
		this.dhxGrid.attachEvent("onRowDblClicked", function(rId,cInd){
			if(cInd == 8) {
				this.dhxWins = new dhtmlXWindows();
				with(this.fileWin = this.dhxWins.createWindow("w1", 0, 0, 484, 378)) {
					setText("Upload image");
					center();
					setModal(true);
					attachHTMLString("<form id='upload-form' action='/adjuster/upload' method='post' enctype='multipart/form-data' target='upload_area'>" +
										"<div id='form-container'></div>" +
									 "</form>");
					uploadForm = new dhtmlXForm("form-container",
						[
							{type: "file", name: "userfile"},
							{type: "container", name: "photo", label: "", inputWidth: 220, inputHeight: 220, offsetTop: 20, offsetLeft: 65},
							{type: "newcolumn"},
							{type: "button", name: "btn-upload", value: "Upload", offsetTop: 225, offsetLeft: 45}
						]
					);
					var originalImage = (obj.dhxGrid.cells(rId, cInd).getValue() == "") ? "empty.jpg" : obj.dhxGrid.cells(rId, cInd).getValue();
					uploadForm.getContainer("photo").innerHTML = "<img src='/uploads/" + originalImage + "' border='0' class='form_photo'>";
					uploadForm.attachEvent("onButtonClick", function(id){
						if (id == "btn-upload") {
							$("#upload-form").submit();
						}
					});
					attachEvent("onClose", function(win){
						if (uploadedImage != null) {
							obj.dhxGrid.cells(rId, cInd).setValue(uploadedImage);
							obj.dhxDP.setUpdated(rId, true, "updated");
							uploadedImage = null;
						}
						return true;
					});
				}
			}
			return true;
		});
	},
	
	initDataProcessor : function() {
		with (this.dhxDP = new dataProcessor("/adjuster/saveadjusters")) {
			setTransactionMode("POST",true);
			setUpdateMode("off");
			enableDataNames(true);
			init(obj.dhxGrid);
		}
	},
	
	loadData : function () {
		with (this.dhxGrid) {
			clearAndLoad("/adjuster/getadjusters");
		}
	},
	
	addData : function () {				
		with(obj.dhxGrid) {
			addRow(uid(), ["", "", "0", new Date()], getRowsNum());
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

function uploadFinished(state, fileName, fileSize) {
	if (state) {
		uploadForm.getContainer("photo").innerHTML = "<img src='/uploads/" + fileName + "' border='0' class='form_photo'>";
		uploadedImage = fileName;
	}
};
function uploadFailure(errorString) {
	alert(errorString);
};
$(window).ready(function() {
	obj = new JSStandard();
	obj.init();
});