     /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     +               SNAKE JavaScript v1.02 by Michael Loesler              +
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
	
	Math.rand = function(min, max) {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}
	
	function getKeyCode(ev) {
		if (!ev) ev = window.event;
		if ((typeof(ev.which) == "undefined" || (typeof(ev.which) == "number" && ev.which == 0)) && typeof(ev.keyCode) == "number")
			return ev.keyCode;
		else	
			return ev.which;
	}

	function Snake(elements) {
		this.isAlive = true;
		this.elements = elements;
		this.colorAlive = "#FF9933";
		this.colorDeath = "#FF0000";
		this.colorHead  = "#EE6600";
		this.interval = null;
		this.speed = 150;
		this.horizontalDirection = -1;
		this.verticalDirection   =  0;
		this.isKeyPressed = false;
		
		this.length = function() {
			return this.elements.length;
		}
		
		this.contains = function( element ) {
			for (var i=0; i<this.length(); i++) 
				if (this.elements[i].x == element.x && this.elements[i].y == element.y)
					return true;
			return false;
		}
		
		this.initSnake = function() {
			for (var i=0; i<this.length(); i++)
				this.elements[i].style.backgroundColor = this.colorAlive;
		}
		
		this.dispatch = function() {
			this.isAlive = false;
			if (this.interval != null)
				window.clearInterval(this.interval);
			for (var i=0; i<this.length(); i++)
				this.elements[i].style.backgroundColor = this.colorDeath;
		}
		
		this.remove = function() {
			this.isAlive = false;
			if (this.interval != null)
				window.clearInterval(this.interval);
			for (var i=0; i<this.length(); i++)
				this.elements[i].style.backgroundColor = this.elements[i].defaultColor;
		}


		this.moveTo = function(newPos, isFoot){

			isFoot = isFoot || false;

			var canMove = !this.contains(newPos)?true:this.elements[this.length()-1].x==newPos.x&&this.elements[this.length()-1].y==newPos.y?true:false;
			
			canMove = canMove || this.horizontalDirection != 0 && this.verticalDirection != 0;
			if (!this.isAlive || !canMove) {
				this.dispatch();
				return;
			}			
			
			var newElements = [];
			newElements.push(newPos);
			for (var i=0; i<this.length(); i++) {
				this.elements[i].style.backgroundColor = this.colorAlive;
				if (i<this.length()-1)
					newElements.push( this.elements[i] );
				else if (i==this.length()-1 && isFoot)
					newElements.push( this.elements[this.length()-1] );
				else
					this.elements[this.length()-1].style.backgroundColor = this.elements[this.length()-1].defaultColor;
			}
			newPos.style.backgroundColor = this.colorHead;
			this.elements = newElements;
			this.isKeyPressed = false;
		}
		var self = this;
		document.onkeydown = function(e){
			if (self.isKeyPressed)
				return;
			var kc = window.getKeyCode(e);
			// links
			if ((kc == 37 || kc == 65) && self.horizontalDirection == 0) {
				self.horizontalDirection = -1;
				self.verticalDirection = 0;
			}
			// hoch
			else if ((kc == 38 || kc == 87) && self.verticalDirection == 0) {
				self.verticalDirection = -1;
				self.horizontalDirection = 0;
			}
			//rechts
			else if ((kc == 39 || kc == 68) && self.horizontalDirection == 0) {
				self.horizontalDirection = 1;
				self.verticalDirection = 0;
			}
			//runter
			else if ((kc == 40 || kc == 83) && self.verticalDirection == 0) {
				self.verticalDirection = 1;
				self.horizontalDirection = 0;
			}
			self.isKeyPressed = true;
		};

		
		this.getElement = function(i) {
			return this.elements[i];
		}
		
		this.initSnake();

	}
	
	function Crumb(element) {
		this.element = element;
		this.isEnable = false;
		this.color = "#006600";
		this.enabled = function(enable) {
			this.element.style.backgroundColor = (this.isEnable = enable)?this.color:this.element.defaultColor;
		}
		this.equalPosition = function( el ) {
			return (this.element.x == el.x && this.element.y == el.y)
		}
	}

	function Terrarium(cellCount) {
		this.cellCount = cellCount;
		this.crumbCounter = 0;
		this.grid = [];
		this.snake = null;
		this.crumb = null;
		this.gridBackgroundColorColor = "transparent";
		
		this.initTable = function() {
			var newGameFontWidth = 7;
			var table = document.createElement("table");
			var tbody = document.createElement("tbody");
			var thead = document.createElement("thead");
			var tfoot = document.createElement("tfoot");
			table.appendChild(tbody);
			table.appendChild(thead);
			table.appendChild(tfoot);
			
			var tr = document.createElement("tr");
			th = document.createElement("th");
			th.colSpan = this.cellCount;
			th.appendChild( document.createTextNode("SNAKE JavaScript") );
			th.title = "SNAKE JavaScript stammt von derletztekick.com - diese Seite besuchen...";
			try { th.style.cursor = "pointer"; } catch(e){ th.style.cursor = "hand"; }
			th.onclick = function() { window.open("http://derletztekick.com", "_blank"); };
			
			/*
			// WIDGET only
			th.style.borderRight = "none";
			th.style.paddingLeft = "15px";
			th.colSpan = this.cellCount-1;
			tr.appendChild(th);
			th = document.createElement("th");
			th.style.borderLeft = "none";
			var closeButton = new Image(10,10);
			closeButton.className = "x";
			closeButton.alt = "x";
			closeButton.src = "./x.png";
			closeButton.title = "Schließen";
			closeButton.style.display = "block";

			closeButton.onclick = function() { window.close(); };
			try { closeButton.style.cursor = "pointer"; } catch(e){ closeButton.style.cursor = "hand"; }
			th.appendChild( closeButton );
			// WIDGET only
			*/
			
			tr.appendChild(th);
			thead.appendChild(tr);
			
			tr = document.createElement("tr");
			var td = document.createElement("td");
			td.colSpan = this.cellCount-newGameFontWidth;
			td.appendChild( document.createTextNode("Counter: " + this.crumbCounter) );
			td.className = "left";
			tr.appendChild(td);
			td = document.createElement("td");
			td.colSpan = newGameFontWidth;
			td.className = "right";
			td.appendChild( document.createTextNode("Level: "));
			for (var i=1; i<4; i++) {
				var span = document.createElement("span");
				span.appendChild( document.createTextNode(i) );
				span.title = "Level " + span.firstChild.nodeValue;
				try { span.style.cursor = "pointer"; } catch(e){ span.style.cursor = "hand"; }
				span.onclick = function() {
					self.insertSnake( parseInt(this.firstChild.nodeValue) );
				}
				td.appendChild( span );
				if (i<3)
					td.appendChild( document.createTextNode(", "));
			}

			
			tr.appendChild(td);
			tfoot.appendChild(tr);
			
			for (var i=0; i<this.cellCount; i++) {
				var tr = document.createElement("tr");
				var row = [];
				for (var j=0; j<this.cellCount; j++) {
					var td = document.createElement("td");
					td.x = i;
					td.y = j;
					td.defaultColor = this.gridBackgroundColorColor;
					row.push(td);
					tr.appendChild(td);
				}
				this.grid.push(row);
				tbody.appendChild(tr);
			}
			return table;
		}
		
		this.updateCounter = function() {
			this.table.tFoot.rows[0].cells[0].firstChild.nodeValue = "Counter: " + (++this.crumbCounter) + " (" +
																	 ((this.snake!=null && this.crumbCounter>0)?(this.snake.length()*100/this.cellCount/this.cellCount).toFixed(0):"0") + "%)";
		}
		
		this.moveSnake = function() {
			var y  = this.snake.horizontalDirection;
			var x  = this.snake.verticalDirection;
			var el = this.snake.getElement(0);

			x = el.x+x;
			y = el.y+y;
				
			x = x<0?this.cellCount-1:x>=this.cellCount?0:x;
			y = y<0?this.cellCount-1:y>=this.cellCount?0:y;	
			
			var cell = this.grid[x][y];
			var isFoot = this.crumb != null && this.crumb.equalPosition( cell );
			this.snake.moveTo( cell, isFoot );
			if (isFoot) {
				this.setCrumb();
				this.updateCounter();
			}
		}
		
		this.setCrumb = function() {
			var x = Math.rand(0, this.cellCount-1);
			var y = Math.rand(0, this.cellCount-1);
			
			if (this.snake.contains( this.grid[x][y] ) )
				this.setCrumb();
			else {
				this.crumb = new Crumb( this.grid[x][y] );
				this.crumb.enabled(true);
			}
				
		}
		
		this.insertSnake = function(speedLevel) {
			speedLevel = speedLevel || 1;
			var sX = Math.ceil(this.cellCount/2)-1,
			    sY = Math.ceil(this.cellCount/2);
			var cells = [ 
				this.grid[sX][sY-2], 
				this.grid[sX][sY-1],
				this.grid[sX][sY-0]
			];
			
			if (this.snake != null)
				this.snake.remove();
			this.crumbCounter = -1;
			this.updateCounter();
			
			this.snake = new Snake( cells );
			
			this.snake.interval = window.setInterval(function() { self.moveSnake(); }, this.snake.speed/speedLevel);
		}
		var self = this;
		this.table = this.initTable();
		this.insertSnake();
		this.setCrumb();
		if ((parEl = document.getElementById("snake")) != null && parEl.appendChild(document.createTextNode("")))
			parEl.replaceChild(this.table, parEl.firstChild);
		else
			document.body.appendChild(this.table);
	
	
	}
	
	var DOMContentLoaded = false;
	function addContentLoadListener (func) {
		if (document.addEventListener) {
			var DOMContentLoadFunction = function () {
				window.DOMContentLoaded = true;
				func();
			};
			document.addEventListener("DOMContentLoaded", DOMContentLoadFunction, false);
		}
		var oldfunc = (window.onload || new Function());
		window.onload = function () {
			if (!window.DOMContentLoaded) {
				oldfunc();
				func();
			}
		};
	}
	
	if (document.getElementById && document.createElement)
		addContentLoadListener( function() { new Terrarium(14); } );