jQuery(document).ready(function($){
	
	//visual composer - trigger change on shortcode_id when editor loads	
	$(document).ajaxComplete(function(event, xhr, settings) {
		if(typeof(settings.data)==="undefined")
			return;
		var request_params=settings.data.split('&');
		if(request_params.indexOf("tag=tt_timetable")!==-1 && request_params.indexOf("action=vc_edit_form")!==-1 && $(".vc_ui-panel-content .vc_shortcode-param select[name='shortcode_id']").val()!=-1)
			$(".vc_ui-panel-content .vc_shortcode-param select[name='shortcode_id']").trigger("change");
	});
	
	//visual composer - google font subset
	$(document).on("change", ".vc_ui-panel-content .vc_shortcode-param select[name='font']", function(event, param) {
		var $this = $(this);
		var font = $this.val();
		if(font==="")
			return;
		$.ajax({
			url: ajaxurl,
			type: 'post',
			data: "action=timetable_get_font_subsets&font=" + font,
			success: function(data){
				data = $.trim(data);
				var indexStart = data.indexOf("timetable_start")+15;
				var indexEnd = data.indexOf("timetable_end")-indexStart;
				data = data.substr(indexStart, indexEnd);
				var options = $.parseHTML(data);				
				var $subset = $(".vc_ui-panel-content .vc_shortcode-param select.font_subset");
				$subset.find("option").remove();
				$subset.append(options);
				if(param!=null)
				{
					$subset.val(param);
				}
			}
		});
	});
	
	//visual composer - time format
	$(document).on("change", ".vc_ui-panel-content .vc_shortcode-param select[name='select_time']", function(event) {
		var $this = $(this);
		var $time_format = $(".vc_ui-panel-content .vc_shortcode-param input[name='time_format']");
		var value = $this.val();
		$time_format.val(value);
	});
	
	//visual composer - choose shortcode ID
	$(document).on("change", ".vc_ui-panel-content .vc_shortcode-param select[name='shortcode_id']", function(event) {
		var $this = $(this);
		var shortcodeId = $this.val();
		vc_timetable_settings_reset();
		if(shortcodeId!="-1")
		{
			var data = {
				'action': "timetable_get_shortcode",
				'timetable_shortcode_id': shortcodeId
			};
			$.ajax({
				url: ajaxurl,
				type: "post",
				data: data,
				dataType: 'html',
				success: function(data){
					//data returns the generated ID of saved shortcode
					//check if list includes the shortcode ID, if yes the edit it, otherwise create new row
					if(data!==0)
					{
						data = $.trim(data);
						var indexStart = data.indexOf("timetable_start")+15;
						var indexEnd = data.indexOf("timetable_end")-indexStart;
						data = data.substr(indexStart, indexEnd);
						//helps to decode HTML entities
						var shortcode = $("<span>").html(data).text();
						var split_character, re;
						if((shortcode.indexOf("\"")!==-1 && shortcode.indexOf("\'")!==-1 && shortcode.indexOf("\'")<shortcode.indexOf("\"")) || (shortcode.indexOf("\"")===-1))
						{
							split_character = "\'";
							re = new RegExp("\'","g");
						}
						else
						{
							split_character = "\"";
							re = new RegExp("\"","g");
						}
						var attributes = shortcode.replace("[tt_timetable ", "").replace("]", "").split(split_character + " ");
						var event=null,event_category=null,hour_category=null,weekday=null,measure=null,filter_style=null,direction=null,filter_kind=null,filter_label=null,filter_label_2=null,time_format=null,hide_hours_column=null,hide_all_events_view=null,show_end_hour=null,event_layout=null,hide_empty=null,disable_event_url=null,text_align=null,row_height=null,id=null,responsive=null,event_description_responsive=null,collapse_event_hours_responsive=null,box_bg_color=null,box_hover_bg_color=null,box_txt_color=null,box_hover_txt_color=null,box_hours_txt_color=null,box_hours_hover_txt_color=null,filter_color=null,row1_color=null,row2_color=null,font_custom=null,font=null,font_subset=null,font_size=null,custom_css=null;
						for(var i=0; i<attributes.length; i++)
						{
							if(attributes[i].indexOf("event=")!=-1)
								event = attributes[i].replace("event=", "").replace(re , "");
							if(attributes[i].indexOf("event_category=")!=-1)
								event_category = attributes[i].replace("event_category=", "").replace(re, "");
							if(attributes[i].indexOf("hour_category=")!=-1)
								hour_category = attributes[i].replace("hour_category=", "").replace(re, "");
							if(attributes[i].indexOf("columns=")!=-1)
								weekday = attributes[i].replace("columns=", "").replace(re, "");
							if(attributes[i].indexOf("measure=")!=-1)
								measure = attributes[i].replace("measure=", "").replace(re, "");
							if(attributes[i].indexOf("filter_style=")!=-1)
								filter_style = attributes[i].replace("filter_style=", "").replace(re, "");
							if(attributes[i].indexOf("direction=")!=-1)
								direction = attributes[i].replace("direction=", "").replace(re, "");
							if(attributes[i].indexOf("filter_kind=")!=-1)
								filter_kind = attributes[i].replace("filter_kind=", "").replace(re, "");
							if(attributes[i].indexOf("filter_label=")!=-1)
								filter_label = attributes[i].replace("filter_label=", "").replace(re, "");
							if(attributes[i].indexOf("filter_label_2=")!=-1)
								filter_label_2 = attributes[i].replace("filter_label_2=", "").replace(re, "");
							if(attributes[i].indexOf("time_format=")!=-1)
								time_format = attributes[i].replace("time_format=", "").replace(re, "");
							if(attributes[i].indexOf("hide_hours_column=")!=-1)
								hide_hours_column = attributes[i].replace("hide_hours_column=", "").replace(re, "");
							if(attributes[i].indexOf("hide_all_events_view=")!=-1)
								hide_all_events_view = attributes[i].replace("hide_all_events_view=", "").replace(re, "");
							if(attributes[i].indexOf("show_end_hour=")!=-1)
								show_end_hour = attributes[i].replace("show_end_hour=", "").replace(re, "");
							if(attributes[i].indexOf("event_layout=")!=-1)
								event_layout = attributes[i].replace("event_layout=", "").replace(re, "");
							if(attributes[i].indexOf("hide_empty=")!=-1)
								hide_empty = attributes[i].replace("hide_empty=", "").replace(re, "");
							if(attributes[i].indexOf("disable_event_url=")!=-1)
								disable_event_url = attributes[i].replace("disable_event_url=", "").replace(re, "");
							if(attributes[i].indexOf("text_align=")!=-1)
								text_align = attributes[i].replace("text_align=", "").replace(re, "");
							if(attributes[i].indexOf("row_height=")!=-1)
								row_height = attributes[i].replace("row_height=", "").replace(re, "");
							if(attributes[i].indexOf("id=")!=-1)
								id = attributes[i].replace("id=", "").replace(re, "");
							if(attributes[i].indexOf("responsive=")!=-1)
								responsive = attributes[i].replace("responsive=", "").replace(re, "");
							if(attributes[i].indexOf("event_description_responsive=")!=-1)
								event_description_responsive = attributes[i].replace("event_description_responsive=", "").replace(re, "");
							if(attributes[i].indexOf("collapse_event_hours_responsive=")!=-1)
								collapse_event_hours_responsive = attributes[i].replace("collapse_event_hours_responsive=", "").replace(re, "");
							if(attributes[i].indexOf("box_bg_color=")!=-1)
								box_bg_color = attributes[i].replace("box_bg_color=", "").replace(re, "").replace("#", "");
							if(attributes[i].indexOf("box_hover_bg_color=")!=-1)
								box_hover_bg_color = attributes[i].replace("box_hover_bg_color=", "").replace(re, "").replace("#", "");
							if(attributes[i].indexOf("box_txt_color=")!=-1)
								box_txt_color = attributes[i].replace("box_txt_color=", "").replace(re, "").replace("#", "");
							if(attributes[i].indexOf("box_hover_txt_color=")!=-1)
								box_hover_txt_color = attributes[i].replace("box_hover_txt_color=", "").replace(re, "").replace("#", "");
							if(attributes[i].indexOf("box_hours_txt_color=")!=-1)
								box_hours_txt_color = attributes[i].replace("box_hours_txt_color=", "").replace(re, "").replace("#", "");	
							if(attributes[i].indexOf("box_hours_hover_txt_color=")!=-1)
								box_hours_hover_txt_color = attributes[i].replace("box_hours_hover_txt_color=", "").replace(re, "").replace("#", "");	
							if(attributes[i].indexOf("filter_color=")!=-1)
								filter_color = attributes[i].replace("filter_color=", "").replace(re, "").replace("#", "");
							if(attributes[i].indexOf("row1_color=")!=-1)
								row1_color = attributes[i].replace("row1_color=", "").replace(re, "").replace("#", "");
							if(attributes[i].indexOf("row2_color=")!=-1)
								row2_color = attributes[i].replace("row2_color=", "").replace(re, "").replace("#", "");
							if(attributes[i].indexOf("font_custom=")!=-1)
								font_custom = attributes[i].replace("font_custom=", "").replace(re, "");
							if(attributes[i].indexOf("font=")!=-1)
								font = attributes[i].replace("font=", "").replace(re, "");
							if(attributes[i].indexOf("font_subset=")!=-1)
								font_subset = attributes[i].replace("font_subset=", "").replace(re, "");
							if(attributes[i].indexOf("font_size=")!=-1)
								font_size = attributes[i].replace("font_size=", "").replace(re, "");
							if(attributes[i].indexOf("custom_css=")!=-1)
								custom_css = attributes[i].replace("custom_css=", "").replace(re, "");
						}
						if(event!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='event']").val(event.split(","));
						if(event_category!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='event_category']").val(event_category.split(","));
						if(hour_category!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='hour_category']").val(hour_category.split(","));
						if(weekday!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='columns']").val(weekday.split(","));
						if(measure!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='measure']").val(measure);
						if(filter_style!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='filter_style']").val(filter_style);
						if(filter_kind!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='filter_kind']").val(filter_kind);
						if(filter_label!=null)
							$(".vc_ui-panel-content .vc_shortcode-param input[name='filter_label']").val(filter_label);
						if(filter_label_2!=null)
							$(".vc_ui-panel-content .vc_shortcode-param input[name='filter_label_2']").val(filter_label_2);
						if(time_format!=null)
						{
							$(".vc_ui-panel-content .vc_shortcode-param input[name='time_format']").val(time_format);
							$(".vc_ui-panel-content .vc_shortcode-param select[name='select_time']").val(time_format);
						}
						if(hide_hours_column!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='hide_hours_column']").val(hide_hours_column);
						if(hide_all_events_view!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='hide_all_events_view']").val(hide_all_events_view);
						if(show_end_hour!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='show_end_hour']").val(show_end_hour);
						if(event_layout!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='event_layout']").val(event_layout);
						if(hide_empty!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='hide_empty']").val(hide_empty);
						if(disable_event_url!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='disable_event_url']").val(disable_event_url);
						if(text_align!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='text_align']").val(text_align);
						if(row_height!=null)
							$(".vc_ui-panel-content .vc_shortcode-param input[name='row_height']").val(row_height);
						if(id!=null)
							$(".vc_ui-panel-content .vc_shortcode-param input[name='id']").val(id);
						if(responsive!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='responsive']").val(responsive);
						if(event_description_responsive!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='event_description_responsive']").val(event_description_responsive);
						if(collapse_event_hours_responsive!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='collapse_event_hours_responsive']").val(collapse_event_hours_responsive);
						if(box_bg_color!=null)
							$(".vc_ui-panel-content .vc_shortcode-param input[name='box_bg_color']").val(box_bg_color).trigger("keyup", [1]);
						if(box_hover_bg_color!=null)
							$(".vc_ui-panel-content .vc_shortcode-param input[name='box_hover_bg_color']").val(box_hover_bg_color).trigger("keyup", [1]);
						if(box_txt_color!=null)
							$(".vc_ui-panel-content .vc_shortcode-param input[name='box_txt_color']").val(box_txt_color).trigger("keyup", [1]);
						if(box_hover_txt_color!=null)
							$(".vc_ui-panel-content .vc_shortcode-param input[name='box_hover_txt_color']").val(box_hover_txt_color).trigger("keyup", [1]);
						if(box_hours_txt_color!=null)
							$(".vc_ui-panel-content .vc_shortcode-param input[name='box_hours_txt_color']").val(box_hours_txt_color).trigger("keyup", [1]);
						if(box_hours_hover_txt_color!=null)
							$(".vc_ui-panel-content .vc_shortcode-param input[name='box_hours_hover_txt_color']").val(box_hours_hover_txt_color).trigger("keyup", [1]);
						if(filter_color!=null)
							$(".vc_ui-panel-content .vc_shortcode-param input[name='filter_color']").val(filter_color).trigger("keyup", [1]);
						if(row1_color!=null)
							$(".vc_ui-panel-content .vc_shortcode-param input[name='row1_color']").val(row1_color).trigger("keyup", [1]);
						if(row2_color!=null)
							$(".vc_ui-panel-content .vc_shortcode-param input[name='row2_color']").val(row2_color).trigger("keyup", [1]);
						if(custom_css!=null)
							$(".vc_ui-panel-content .vc_shortcode-param textarea[name='custom_css']").val(custom_css);
						if(font_custom!=null)
							$(".vc_ui-panel-content .vc_shortcode-param input[name='timetable_font_custom']").val(font_custom);
						if(font!=null)
							$(".vc_ui-panel-content .vc_shortcode-param select[name='font']").val(font).trigger("change", (font_subset!=null ? [font_subset.split(",")] : null));
						if(font_size!=null)
							$(".vc_ui-panel-content .vc_shortcode-param input[name='timetable_font_size']").val(font_size);
					} else {
						console.log("error occured");
					}
				}
			});
		}
	});
});

//visual composer - google font subset initialization
function timetable_font_subset_init() {
	var $ = jQuery;
	var $google_font = $(".vc_shortcode-param select.font");
	var font = $google_font.val();
	if(font==="")
		return;
	$.ajax({
		url: ajaxurl,
		type: 'post',
		data: "action=timetable_get_font_subsets&font=" + font,
		success: function(data){
			data = $.trim(data);
			var indexStart = data.indexOf("timetable_start")+15;
			var indexEnd = data.indexOf("timetable_end")-indexStart;
			data = data.substr(indexStart, indexEnd);
			var options = $.parseHTML(data);
			var $subset = $(".vc_shortcode-param select.font_subset");
			var old_value = $subset.find("option:selected").val();
			$subset.find("option").remove();
			$subset.append(options);
			$subset.val(old_value);
		}
	});	
}

//visual composer - clear timetable configuration
function vc_timetable_settings_reset()
{
	var $ = jQuery;
	$(".vc_ui-panel-content .vc_shortcode-param select[name='event']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param select[name='event_category']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param select[name='hour_category']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param select[name='columns']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param select[name='measure']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param select[name='filter_style']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param select[name='filter_kind']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param input[name='filter_label']").val("All Events");
	$(".vc_ui-panel-content .vc_shortcode-param input[name='filter_label_2']").val("All Events Categories");
	$(".vc_ui-panel-content .vc_shortcode-param input[name='time_format']").val("H.i");
	$(".vc_ui-panel-content .vc_shortcode-param select[name='select_time']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param select[name='hide_hours_column']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param select[name='hide_all_events_view']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param select[name='show_end_hour']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param select[name='event_layout']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param select[name='hide_empty']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param select[name='disable_event_url']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param select[name='text_align']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param input[name='row_height']").val("31");
	$(".vc_ui-panel-content .vc_shortcode-param input[name='id']").val("");
	$(".vc_ui-panel-content .vc_shortcode-param select[name='responsive']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param select[name='event_description_responsive']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param select[name='collapse_event_hours_responsive']")[0].selectedIndex = 0;
	$(".vc_ui-panel-content .vc_shortcode-param input[name='box_bg_color']").val("00A27C").trigger("keyup", [1]);
	$(".vc_ui-panel-content .vc_shortcode-param input[name='box_hover_bg_color']").val("1F736A").trigger("keyup", [1]);
	$(".vc_ui-panel-content .vc_shortcode-param input[name='box_txt_color']").val("FFFFFF").trigger("keyup", [1]);
	$(".vc_ui-panel-content .vc_shortcode-param input[name='box_hover_txt_color']").val("FFFFFF").trigger("keyup", [1]);
	$(".vc_ui-panel-content .vc_shortcode-param input[name='box_hours_txt_color']").val("FFFFFF").trigger("keyup", [1]);
	$(".vc_ui-panel-content .vc_shortcode-param input[name='box_hours_hover_txt_color']").val("FFFFFF").trigger("keyup", [1]);
	$(".vc_ui-panel-content .vc_shortcode-param input[name='filter_color']").val("00A27C").trigger("keyup", [1]);
	$(".vc_ui-panel-content .vc_shortcode-param input[name='row1_color']").val("F0F0F0").trigger("keyup", [1]);
	$(".vc_ui-panel-content .vc_shortcode-param input[name='row2_color']").val("").trigger("keyup", [1]);
	$(".vc_ui-panel-content .vc_shortcode-param textarea[name='custom_css']").val("");
	$(".vc_ui-panel-content .vc_shortcode-param input[name='timetable_font_custom']").val("");
	$(".vc_ui-panel-content .vc_shortcode-param select[name='font']").val("").trigger("change");
	$(".vc_ui-panel-content .vc_shortcode-param input[name='timetable_font_size']").val("");
}
