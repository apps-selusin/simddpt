// Create calendar
function ew_CreateCalendar(formid, id, formatid) {
	if (id.indexOf("$rowindex$") > -1)
		return;
	var $ = jQuery, el = ew_GetElement(id, formid), $el = $(el), format = "";
	if ($el.parent().is(".input-group"))
		return;
	var $btn = $('<button type="button"><span class="glyphicon glyphicon-calendar"></span></button>')
		.addClass("btn btn-default btn-sm").css({ "font-size": $el.css("font-size"), "height": $el.outerHeight() })
		.click(function() { $(this).closest(".has-error").removeClass("has-error"); });
	var getDateTimeFormatId = function(id, withtime) {
		if (id == 5 || id == 9)
			return withtime ? 9 : 5;
		else if (id == 6 || id == 10)
			return withtime ? 10 : 6;
		else if (id == 7 || id == 11)
			return withtime ? 11 : 7;
		else if (id == 12 || id == 15)
			return withtime ? 15 : 12;
		else if (id == 13 || id == 16)
			return withtime ? 16 : 13;
		else if (id == 14 || id == 17)
			return withtime ? 17 : 14;
		return id;
	}
	if (formatid == 0)
		formatid = EW_DATE_FORMAT_ID;
	else if (formatid == 1)
		formatid = getDateTimeFormatId(EW_DATE_FORMAT_ID, true);
	else if (formatid == 2)
		formatid = getDateTimeFormatId(EW_DATE_FORMAT_ID, false);
	if (formatid == 12 || formatid == 15) {
		format = "%y/%m/%d";
	} else if (formatid == 5 || formatid == 9) {
		format = "%Y/%m/%d";
	} else if (formatid == 14 || formatid == 17) {
		format = "%d/%m/%y";
	} else if (formatid == 7 || formatid == 11) {
		format = "%d/%m/%Y";
	} else if (formatid == 13 || formatid == 16) {
		format = "%m/%d/%y";
	} else if (formatid == 6 || formatid == 10) {
		format = "%m/%d/%Y";
	}
	var withtime = ew_InArray(formatid, [9, 10, 11, 15, 16, 17]) > -1;
	if (withtime)
		format += " %H:%M:%S";
	format = format.replace(/\//g, EW_DATE_SEPARATOR).replace(/:/g, EW_TIME_SEPARATOR);
	var settings = {
		inputField: el, // input field
		showsTime: withtime, // shows time
		ifFormat: format, // date format
		button: $btn[0], // button
		cache: true // reuse the same calendar object, where possible
	};
	var args = {"id": id, "form": formid, "enabled": true, "settings": settings, "language": EW_LANGUAGE_ID};
	$el.wrap('<div class="input-group"></div>').after($('<span class="input-group-btn"></span>').append($btn));
	$(function() {
		$(document).trigger("calendar", [args]);
		if (!args.enabled)
			return;
		if (!Calendar._DN) {
			$.getScript(EW_RELATIVE_PATH + "calendar/lang/calendar-" + (args.language || "en") + ".js")
				.fail(function() {
					$.getScript(EW_RELATIVE_PATH + "calendar/lang/calendar-en.js");
				});
		}
		Calendar.setup(args.settings);
	});
}


