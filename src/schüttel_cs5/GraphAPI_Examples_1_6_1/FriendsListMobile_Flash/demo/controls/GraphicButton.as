﻿/*	Copyright (c) 2010, Adobe Systems Incorporated	All rights reserved.		Redistribution and use in source and binary forms, with or without	modification, are permitted provided that the following conditions are	met:		* Redistributions of source code must retain the above copyright notice,	this list of conditions and the following disclaimer.		* Redistributions in binary form must reproduce the above copyright	notice, this list of conditions and the following disclaimer in the	documentation and/or other materials provided with the distribution.		* Neither the name of Adobe Systems Incorporated nor the names of its	contributors may be used to endorse or promote products derived from	this software without specific prior written permission.		THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS	IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,	THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR	PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR	CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,	EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,	PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR	PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF	LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING	NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS	SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.*/package demo.controls {		import flash.display.MovieClip;	import flash.text.TextField;	import flash.events.MouseEvent;	import flash.text.TextFormat;	import flash.text.TextFieldAutoSize;	import flashx.textLayout.formats.TextAlign;		public class GraphicButton extends MovieClip {				public var displayLabel:TextField;		public var highlight:MovieClip;		public var selectedClip:MovieClip;				protected var _enabled:Boolean;		protected var tf:TextFormat;				public function GraphicButton() {			// constructor code			configUI();		}				public function get label():String { return displayLabel.text; }		public function set label(value:String):void {			displayLabel.text = value;		}				public function setSize(w:Number, h:Number):void {			bg.width = w;			bg.height = h;						highlight.width = w+1;			highlight.height = h;						selectedClip.width = w+1;			selectedClip.height = h;						displayLabel.x = bg.width - displayLabel.width>>1;			displayLabel.y = bg.height - displayLabel.height>>1;		}		 		public function setStyle(prop:String, value:*):void {			if (prop == 'icon') {				displayLabel.visible = false;				value.x = bg.width - value.width>>1;				value.y = bg.height - value.height>>1;				addChild(value);				return;			}			tf[prop] = value;			displayLabel.setTextFormat(tf);					}				override public function get enabled():Boolean { return _enabled; }		override public function set enabled(value:Boolean):void {			_enabled = value;			if (_enabled) {				this.addEventListener(MouseEvent.ROLL_OVER, onOver, false, 0, true)				this.addEventListener(MouseEvent.ROLL_OUT, onOut, false, 0, true);				this.addEventListener(MouseEvent.MOUSE_DOWN, onClick, false, 0, true);				this.addEventListener(MouseEvent.MOUSE_UP, onOver, false, 0, true);			} else {				this.removeEventListener(MouseEvent.ROLL_OVER, onOver);				this.removeEventListener(MouseEvent.ROLL_OUT, onOut);				this.removeEventListener(MouseEvent.MOUSE_DOWN, onClick);				this.removeEventListener(MouseEvent.MOUSE_UP, onOver);			}		}				protected function configUI():void {			enabled = true;						this.useHandCursor = true;			this.buttonMode = true;						tf = new TextFormat();			tf.align = TextAlign.CENTER;						displayLabel.mouseEnabled = false;			displayLabel.selectable = false;						setStyle('font', '_sans');			setStyle('size', 125);						displayLabel.setTextFormat(tf);			highlight.visible = false;			selectedClip.visible = false;		}				protected function onClick(event:MouseEvent):void {			this.gotoAndStop(3);			selectedClip.visible = true;		}				protected function onOver(event:MouseEvent):void {			this.gotoAndStop(2);			highlight.visible = true;			selectedClip.visible = false;		}				protected function onOut(event:MouseEvent):void {			this.gotoAndStop(1);			highlight.visible = false;			selectedClip.visible = false;		}	}	}