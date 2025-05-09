function newFlxPlayer(sel) {
    var self = {};
    
    self.bui = function () {
        var vid = self.control[0].outerHTML;
        var html = "";
        html += "<div class='flx-progress'></div>";
        
        html = "<div class='flx-wrap'>" + vid + html + "</div>" ;
        self.control[0].outerHTML = html;
    }
    
    self.init = function (sel) {
        self.control = $(sel).first();
        self.bui();
    }
    
    self.init(sel);
    
    return self;
}

