!function(a){function c(a){function c(c){b.locked||b.x!=-1&&(b.x=-1,a.triggerRedrawOverlay())}function d(c){if(!b.locked){if(a.getSelection&&a.getSelection())return void(b.x=-1);var d=a.offset();b.x=Math.max(0,Math.min(c.pageX-d.left,a.width())),b.y=Math.max(0,Math.min(c.pageY-d.top,a.height())),a.triggerRedrawOverlay()}}var b={x:-1,y:-1,locked:!1};a.setCrosshair=function(d){if(d){var e=a.p2c(d);b.x=Math.max(0,Math.min(e.left,a.width())),b.y=Math.max(0,Math.min(e.top,a.height()))}else b.x=-1;a.triggerRedrawOverlay()},a.clearCrosshair=a.setCrosshair,a.lockCrosshair=function(d){d&&a.setCrosshair(d),b.locked=!0},a.unlockCrosshair=function(){b.locked=!1},a.hooks.bindEvents.push(function(a,b){a.getOptions().crosshair.mode&&(b.mouseout(c),b.mousemove(d))}),a.hooks.drawOverlay.push(function(a,c){var d=a.getOptions().crosshair;if(d.mode){var e=a.getPlotOffset();if(c.save(),c.translate(e.left,e.top),b.x!=-1){var f=a.getOptions().crosshair.lineWidth%2===0?0:.5;if(c.strokeStyle=d.color,c.lineWidth=d.lineWidth,c.lineJoin="round",c.beginPath(),d.mode.indexOf("x")!=-1){var g=Math.round(b.x)+f;c.moveTo(g,0),c.lineTo(g,a.height())}if(d.mode.indexOf("y")!=-1){var h=Math.round(b.y)+f;c.moveTo(0,h),c.lineTo(a.width(),h)}c.stroke()}c.restore()}}),a.hooks.shutdown.push(function(a,b){b.unbind("mouseout",c),b.unbind("mousemove",d)})}var b={crosshair:{mode:null,color:"rgba(170, 0, 0, 0.80)",lineWidth:1}};a.plot.plugins.push({init:c,options:b,name:"crosshair",version:"1.0"})}(jQuery);