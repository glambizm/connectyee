/*
 * connectyee.calendarmaker.js
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
 */
(function($) {
    $.fn.calendarmaker = function(TargetDate) {
        if ((TargetDate instanceof Date) === false) {
            return this;
        }

        if (this.is('table') === false) {
            return this;
        }

        this.empty();

        var thStr = ['', 'SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];

        var trHeader = $('<tr>');
        for (var i = 1; i <= 7; i++) {
            var thObj = $('<th>');
            thObj.text(thStr[i]);
            trHeader.append(thObj);
        }
        this.append(trHeader);

        i = 1;
        var endDayObj = new Date(TargetDate.getFullYear(), TargetDate.getMonth() + 1, 0);
        var endDay = endDayObj.getDate();
        for (var j = 1; j <= 6; j++) {
            var trBody = $('<tr>');
            for (var k = 0; k <= 6; k++) {
                var tdObj = $('<td>');
                if (endDay >= i) {
                    var tmpDate = new Date(TargetDate.getFullYear(), TargetDate.getMonth(), i);
                    if (tmpDate.getDay() === k) {
                        tdObj.text(i);
                        i++;
                    }
                }
                trBody.append(tdObj);
            }
            this.append(trBody);
        }
        return this;
    };
})(jQuery);
