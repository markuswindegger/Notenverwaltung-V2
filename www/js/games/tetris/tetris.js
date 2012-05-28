     /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     +                  JS Tetris v1.1a by Michael Loesler                  +
     ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     + Copyright (C) by Michael Loesler, http//derletztekick.com            +
     +                                                                      +
     +                                                                      +
     + This program is free software; you can redistribute it and/or modify +
     + it under the terms of the GNU General Public License as published by +
     + the Free Software Foundation; either version 2 of the License, or    +
     + (at your option) any later version.                                  +
     +                                                                      +
     + This program is distributed in the hope that it will be useful,      +
     + but WITHOUT ANY WARRANTY; without even the implied warranty of       +
     + MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        +
     + GNU General Public License for more details.                         +
     +                                                                      +
     + You should have received a copy of the GNU General Public License    +
     + along with this program; if not, write to the                        +
     + Free Software Foundation, Inc.,                                      +
     + 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.            +
     +                                                                      +
      ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
		
			function GamePad(rows, cols, id, gOn, sOn){
				this.Table = document.createElement("table");
				this.id = id;
				this.rows = rows;
				this.cols = cols;
				this.interval = null;
				this.score = 0;
				this.counter = 750;
				this.isKeyUp = true;
				this.TokenTypes = new Array();
				while (this.TokenTypes.length < 2) 
					this.TokenTypes.push( Math.round( (sOn?10:6) *Math.random()) );
				if (gOn)
					var borderFreeField = "1px solid #ddd";
				else
					var borderFreeField = "1px solid transparent";
				var borderFullField = "1px solid black";
						
				//this.Table.style.borderCollapse = "collapse";
				this.Table.style.margin = "auto";
				this.Table.style.border = "1px solid black";
				
				this.TBody = document.createElement("tbody");
				this.Table.appendChild(this.TBody);
				this.TFoot = this.Table.createTFoot();
				var aRow = this.TFoot.insertRow(0);
				var FootScoreCell = aRow.insertCell(0);
				var FootNewGameCell = aRow.insertCell(1);
				FootScoreCell.colSpan = Math.ceil(cols/2);
				FootScoreCell.style.fontSize = "x-small";
				FootScoreCell.style.textAlign = "left";
				FootScoreCell.appendChild(document.createTextNode("Score:"));
				this.updateScore = function(val) {
					this.score += val;
					FootScoreCell.firstChild.replaceData(0, FootScoreCell.firstChild.nodeValue.length, "Score: "+this.score);
				};
				FootNewGameCell.Instanz = this;
				FootNewGameCell.colSpan = cols-Math.ceil(cols/2);
				FootNewGameCell.style.fontSize = "x-small";
				FootNewGameCell.style.textAlign = "right";
				FootNewGameCell.appendChild(document.createTextNode("Neues Spiel"));
				FootNewGameCell.onclick = function() { destroyObj(FootNewGameCell.Instanz); initGame(document.getElementById("jstetrisGridOn").checked, document.getElementById("jstetrisSpecialToken").checked); };
				FootNewGameCell.title = "Neues Spiel starten";
				try { FootNewGameCell.style.cursor = "pointer"; }
				catch(e){ FootNewGameCell.style.cursor = "hand"; }
				
				this.cells = new Array();
				for (var i=0; i<this.rows; i++){
					var TR = this.TBody.insertRow(i);
					for (var j=0; j<this.cols; j++){
						var TD = TR.insertCell(j); 
						TD.appendChild(document.createTextNode( String.fromCharCode(160) ));
						TD.style.border = borderFreeField;
						TD.style.lineHeight = "12px";
						TD.style.fontSize = "12px";
						TD.style.width = "12px";
						TD.isEditable = true;
						TR.appendChild(TD);
					}
					this.cells[i] = TR.cells;
				}
								
				this.cells.getCompleteLines = function (){
					var lines = new Array();
					for (var i=0; i<this.length; i++){
						var isCompleted = true;
						for (var j=0; j<this[i].length; j++){
							if (this[i][j].isEditable){
								isCompleted = false;
								break;
							}
						}
						if(isCompleted){
							lines.push(i);
						}
					}
					return (lines.length>0?lines:null);
				}
				
				this.reshapeCompleteLines = function(){
					var lines = this.cells.getCompleteLines();
					function Numsort (a, b) {
						return a - b;
					}
					if (lines != null){
						lines.sort(Numsort);
						for (var k=0; k<lines.length; k++){
							for (var i=lines[k]; i>=0; i--){
								for (var j=0; j<this.cols; j++){
									if (i>0){
										this.cells[i][j].style.backgroundColor = this.cells[i-1][j].style.backgroundColor;
										this.cells[i][j].style.borderColor = this.cells[i-1][j].style.borderColor;
										this.cells[i][j].isEditable = this.cells[i-1][j].isEditable;
									}
									else {
										this.cells[i][j].style.backgroundColor = "transparent";
										this.cells[i][j].style.border = borderFreeField;
										this.cells[i][j].isEditable = true;
									}
								}
							}
						}
						
						
						this.updateScore(Math.round(lines.length*10*Math.pow((sOn?1.75:1.5),lines.length)));
						this.counter = (this.counter-25 <= 0)?0:this.counter -= 25;
					}
				}
				
				this.addON = function(parentGame, parentOption){
					parentGame.replaceChild(this.Table, parentGame.firstChild);
					this.previewToken( parentOption );
				}
				
				this.canInsert = function(T,north,east){
					for (var i=0; i<T.height(); i++){
						for (var j=0; j<T.width(); j++){
							if (north > this.rows){
								return false;
							}
							else if (east <= 0){
								return false;
							}
							else if (east+T.width()-1 > this.cols){
								return false;
							}
							else if (i+north-T.height()>=0 && T.figure[i][j] && !this.cells[i+north-T.height()][j+east-1].isEditable){
								return false;
							}
						}
					}
					return true;
				}
				
				this.insertToken = function(T,north,east){
					for (var i=0; i<T.height(); i++){
						for (var j=0; j<T.width(); j++){
							if (T.figure[i][j] && i+north-T.height()>=0 && this.cells[i+north-T.height()][j+east-1].isEditable){
								this.cells[i+north-T.height()][j+east-1].style.backgroundColor = T.color;
								this.cells[i+north-T.height()][j+east-1].style.border = borderFullField;
							}							
						}
					}
					T.x = east;
					T.y = north;
				}
				
				this.removeToken = function(T){
					for (var i=T.height()-1; i>=0; i--){
						for (var j=0; j<T.width(); j++){
							if (T.figure[i][j] && (i+T.y-T.height()) >= 0){
								this.cells[i+T.y-T.height()][T.x+j-1].style.backgroundColor = "transparent";
								this.cells[i+T.y-T.height()][T.x+j-1].style.border = borderFreeField;
							}
						}
					}
				}
				
				this.setEditable = function(T,val){
					for (var i=T.height()-1; i>=0; i--){
						for (var j=0; j<T.width(); j++){
							if (T.figure[i][j] && (i+T.y-T.height()) >= 0){
								this.cells[i+T.y-T.height()][T.x+j-1].isEditable = false; 
								this.cells[i+T.y-T.height()][T.x+j-1].style.backgroundColor = "lightGrey";
							}
						}
					}
					this.reshapeCompleteLines();
				}
				
				this.moveSidelongToken = function(T, step){
					if (this.canInsert(T,T.y,(T.x+step))){
						this.removeToken(T);
						this.insertToken(T,T.y,(T.x+step));
					}
				}
				
				this.nextToken = function() {
					this.TokenTypes[1] = this.TokenTypes[0];
					this.TokenTypes[0] = Math.round( (sOn?10:6) *Math.random());
					this.previewToken();
				}
				
				this.previewToken = function(parent) {
					var T = new Token( this.TokenTypes[0] );
					if (!document.getElementById("JSTetrisPreviewTable")){
						var prevTable = document.createElement("table");
						var prevTbody = document.createElement("tbody");
						prevTable.appendChild( prevTbody );
						prevTable.id = "JSTetrisPreviewTable";
						
						parent.appendChild( prevTable );
					}
					else {
						var prevTable = document.getElementById("JSTetrisPreviewTable");
					}
					
					var prevTbody = document.createElement("tbody");

					for (var i=0; i<T.height(); i++) {	//T.height();
						var prevTR = document.createElement("tr");
						for (var j=0; j<=5; j++){	//T.width();
							var prevTD = document.createElement("td");
							if (i<T.height() && j<T.width() &&T.figure[i][j]) {
								prevTD.style.backgroundColor = T.color;
								prevTD.style.border = borderFullField;
							}
							else {
								prevTD.style.backgroundColor = "transparent";
								prevTD.style.border = "1px solid transparent";
							}
							prevTD.appendChild(document.createTextNode( String.fromCharCode(160) ));
							prevTD.style.lineHeight = "15px";
							prevTD.style.fontSize = "15px";
							prevTD.style.width = "15px";
							prevTR.appendChild( prevTD );
							
						}
						prevTbody.appendChild( prevTR );
					}
					prevTable.replaceChild(prevTbody, prevTable.firstChild);
				}
				
				this.moveDownToken = function(T, step, flag){
					if (typeof(step) == "undefined")
						step = 1;
					if (typeof(flag) == "undefined")
						flag = true;
					
					if (this.canInsert(T,(T.y+step),T.x)){
						this.removeToken(T);
						this.insertToken(T,(T.y+step),T.x);
						this.score++;
					}
					else {
						this.setEditable(T,false);
						this.isKeyUp=flag;
						T.isAktiv = false;
						clearInterval(this.interval);
						this.nextToken();
						this.interval = null;
						this.updateScore(5);
						initBlock(this, this.TokenTypes[1]);
					}
				}
			}
			
			
			function Token(nr){
				var tokenColor = ["blue", "green", "red", "darkblue", "darkred", "violet", "orange", "black"];
				var figureTypes = [];
				figureTypes[0] =  [[true, false, false],
									[true, true, true]];

				figureTypes[1] =  [[false, false, true],
									[true, true, true]];
										
				figureTypes[2] =  [[true, true, true, true]];
				
				figureTypes[3] =  [[true, true, true],
									[false, true, false]];
										
				figureTypes[4] =  [[true, true, false],
									[false, true, true]];
										
				figureTypes[5] =  [[false, true, true],
									[true, true, false]];
										
				figureTypes[6] =  [[true, true],
									[true, true]];
							

				//Special
				figureTypes[7] =  [[false, true, false],
									[true, true, true],
									[false, true, false]];

				figureTypes[8] =  [[true, false, false],
									[true, true, true],
									[false, false, true]];

				figureTypes[9] =  [[false, false, true],
									[true, true, true],
									[true, false, false]];	

				figureTypes[10] =  [[true, false, true],
									[true, true, true]];									

				nr = nr>=figureTypes.length?figureTypes.length-1:nr;
				this.figure = figureTypes[nr];	
				
				this.width = function() { return this.figure[0].length; };
				this.height = function() { return this.figure.length; };

				nr = nr>=tokenColor.length?tokenColor.length-1:nr;
				this.color = tokenColor[nr];
				this.isAktiv = true;
				
				this.x = 0;
				this.y = this.height();
								
				this.rotate = function(val){
					if (typeof(val) == "undefined"){
						val = 1;
					}
					
					var R = new Array();
					R[0] = new Array(0, (-1*val));
					R[1] = new Array((1*val),  0);
					
					var array = new Array(this.width());
					for (var i=0; i<array.length; i++){
						array[i] = new Array(this.height());
					}

					for (var i=0; i<this.height(); i++){
						for (var j=0; j<this.width(); j++){
							if (val == 1){
								array[(i*R[0][0] + j*R[1][0])][(i*R[0][1] + j*R[1][1]+this.height()-1)] = this.figure[i][j];
							}
							else if(val==-1){
								array[(i*R[0][0] + j*R[1][0]+this.width()-1)][(i*R[0][1] + j*R[1][1])] = this.figure[i][j];
							}
						}
					}
					this.figure = null;
					this.figure = new Array(array.length);
					for (var i=0; i<array.length; i++){
						this.figure[i] = new Array();
						for (var j=0; j<array[i].length; j++){
							this.figure[i][j] = array[i][j];
						}
					}
				}
			}
						
			function getKeyCode(ev) {
				if (!ev) ev = window.event;
				if ((typeof(ev.which) == "undefined" || (typeof(ev.which) == "number" && ev.which == 0)) && typeof(ev.keyCode) == "number")
					return ev.keyCode;
				else	
					return ev.which;
			}
			
			function destroyObj(Obj){
				if (typeof(Obj) == "object"){
					clearInterval(Obj.interval);
					Obj.interval = null;
					Obj = null;
					delete Obj;
				}
			}
			
			function initBlock(GP, TokenNumber){
				var Block = new Token( TokenNumber );
				Block.x = parseInt(0.5*GP.cols);
				Block.y = 1;
				if (GP.canInsert(Block,Block.y,Block.x)){
					GP.insertToken(Block,Block.y,Block.x);
					GP.interval = window.setInterval(function() { GP.moveDownToken(Block); },GP.counter);
				}
				else {
					Block.isAktiv = false;
					destroyObj(GP);
				}
				
				document.onkeyup = function(e){
					GP.isKeyUp = true;
				};

				if (typeof(window.event) != "undefined" && !window.opera)
					document.onkeydown = function(e) {
						if (Block.isAktiv && GP.isKeyUp){
							var kc = getKeyCode(e); 
							if (kc == 37){
								GP.moveSidelongToken(Block, -1);
							}
							else if(kc == 39){
								GP.moveSidelongToken(Block, 1);
							}
							else if(kc == 40){
								GP.moveDownToken(Block,1,false);
							}
						}
					};
										
				document.onkeypress = function(e) {
					if (Block.isAktiv && GP.isKeyUp){
						var kc = getKeyCode(e); 						
						if (kc == 32 || kc == 38 || kc == 83 || kc == 115 || kc == 105 || kc == 73) {
							Block.rotate();
							if (GP.canInsert(Block,Block.y,Block.x)){
								Block.rotate(-1);
								GP.removeToken(Block);
								Block.rotate();
								GP.moveSidelongToken(Block, 0);
							}
							else {
								Block.rotate(-1);
							}
						}
						else if (kc == 65 || kc == 97) {
							Block.rotate(-1);
							if (GP.canInsert(Block,Block.y,Block.x)){
								Block.rotate();
								GP.removeToken(Block);
								Block.rotate(-1);
								GP.moveSidelongToken(Block, 0);
							}
							else {
								Block.rotate();
							}
						}
						else if(kc == 37 || kc == 74 || kc==106){
							GP.moveSidelongToken(Block, -1);
						}
						else if(kc == 39 || kc == 76 || kc==108){
							GP.moveSidelongToken(Block, 1);
						}
						else if(kc == 40 || kc == 75 || kc ==107){
							GP.moveDownToken(Block,1,false);
						}
						else if(kc == 13){
							while (Block.isAktiv){
								GP.moveDownToken(Block,1,false);
							}
						}
					}
				};
			}
			
			
			function createCheckbox(str,v,c,id) {
				var p = document.createElement("p");
				try {
					var inp = document.createElement("input");
					inp.type = "checkbox";
				}
				catch(err) {
					var inp = document.createElement('<input type="checkbox">');
				}
				
				p.appendChild( inp );
				p.style.fontSize = "x-small";
				p.appendChild(document.createTextNode( "  "+str ));
				inp.checked = c;
				inp.value = v;
				inp.id = id;
				return p;
			}

			function initGame(gOn, sOn) {
				var mainTable = document.createElement("table");
				mainTable.style.border = "1px solid lightGrey";
				var mainTableBody = document.createElement("tbody");
				var mainTableTR = document.createElement("tr");
				var mainTableTH = document.createElement("th");
				mainTableTH.colSpan = 2;
				var span = document.createElement("span");
				span.appendChild(document.createTextNode( "JavaScript Tetris" ));
				try { span.style.cursor = "pointer"; } catch(e){ span.style.cursor = "hand"; }
				span.onclick = function(e) { window.open("http://derletztekick.com", "_blank"); };
				span.title = "JavaScript Tetris stammt von derletztekick.com - diese Seite besuchen...";
				mainTableTH.appendChild( span );
				
				/*
				// OPERA WidGET only
				mainTableTH.style.verticalAlign = "top";
				mainTableTH.style.height = "15px";
				var closeButton = new Image(10,10);
				closeButton.className = "x";
				closeButton.alt = "x";
				closeButton.src = "./x.png";
				closeButton.title = "Schließen";
				closeButton.style.display = "block";
				closeButton.style.cssFloat = "right";
				closeButton.onclick = function() { window.close(); };
				try { closeButton.style.cursor = "pointer"; } catch(e){ closeButton.style.cursor = "hand"; }
				mainTableTH.appendChild( closeButton );
				*/
				
				mainTableTR.appendChild( mainTableTH );
				mainTableBody.appendChild( mainTableTR );
				mainTableTR = document.createElement("tr");
				var mainTableTD_GamePad = document.createElement("td");
				var mainTableTD_Preview = document.createElement("td");
				var mainTableTD_Option = document.createElement("td");
				mainTableTD_GamePad.appendChild(document.createTextNode( String.fromCharCode(160) ));
				mainTableTD_Preview.appendChild(document.createTextNode( String.fromCharCode(160) ));
				mainTableTD_Option.appendChild(document.createTextNode( String.fromCharCode(160) ));
				mainTableTD_GamePad.rowSpan = 2;
				mainTable.style.margin = "auto";
				mainTable.appendChild( mainTableBody );
				mainTableBody.appendChild( mainTableTR );
				mainTableTR.appendChild( mainTableTD_GamePad );
				mainTableTR.appendChild( mainTableTD_Preview );
				mainTableTD_Preview.style.verticalAlign = "top";
				
				mainTableTR = document.createElement("tr");
				mainTableBody.appendChild( mainTableTR );
				mainTableTR.appendChild( mainTableTD_Option );
				mainTableTD_Option.style.textAlign = "left";

				mainTableTD_Option.appendChild( createCheckbox("Grid On", "grid on/off", gOn, "jstetrisGridOn") );
				mainTableTD_Option.appendChild( createCheckbox("Spezial", "special", sOn, "jstetrisSpecialToken") );

				document.getElementById("js-tetris").replaceChild(mainTable, document.getElementById("js-tetris").firstChild);
				var GP = new GamePad(20, 11, "gamepad", gOn, sOn);
				GP.addON(mainTableTD_GamePad, mainTableTD_Preview);
				
				initBlock(GP, Math.round( (sOn?10:6) *Math.random()));
			}
			
			var oldonload=null;
			if (typeof(window.onload) != "undefined" ){
				oldonload=window.onload;
			}
			window.onload = function() { if(oldonload != null) {oldonload();} initGame(true, false); };