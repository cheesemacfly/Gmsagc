var year = new Date().getFullYear();
var month = new Date().getMonth();
var day = new Date().getDate();


$(document).ready(function() {
  $('#calendar').weekCalendar({
    //data: 'events.json',
    date: new Date('2009-05-10T13:15:00.000+10:00'),
    minDate: new Date('2009-05-01T13:15:00.000+10:00'),
    maxDate: new Date('2009-05-20T13:15:00.000+10:00'),
    switchDisplay: {'1 day': 1,'3 days': 3,'Work week': 5, 'Full week': 7},
    timeslotsPerHour: 4,
    height: function($calendar) {
      return $(window).height() - $('h1').outerHeight() - $('.description').outerHeight();
    },
    eventRender: function(calEvent, $event) {
      if (calEvent.end.getTime() < new Date().getTime()) {
        $event.css('backgroundColor', '#aaa');
        $event.find('.time').css({
          backgroundColor: '#999',
          border:'1px solid #888'
        });
      }
    },
    eventNew: function(calEvent, $event) {
        calEvent.user = 1;
        calEvent.order = 1;
      displayMessage('<strong>Added event</strong><br/>Start: ' + calEvent.start + '<br/>End: ' + calEvent.end);
      $.post(Routing.generate('ngpp_gmsagc_hours_save'), calEvent);
    },
    eventDrop: function(calEvent, $event) {
      displayMessage('<strong>Moved Event</strong><br/>Start: ' + calEvent.start + '<br/>End: ' + calEvent.end);
    },
    eventResize: function(calEvent, $event) {
      displayMessage('<strong>Resized Event</strong><br/>Start: ' + calEvent.start + '<br/>End: ' + calEvent.end);
    },
    eventClick: function(calEvent, $event) {
      displayMessage('<strong>Clicked Event</strong><br/>Start: ' + calEvent.start + '<br/>End: ' + calEvent.end);
    },
    eventMouseover: function(calEvent, $event) {
      displayMessage('<strong>Mouseover Event</strong><br/>Start: ' + calEvent.start + '<br/>End: ' + calEvent.end);
    },
    eventMouseout: function(calEvent, $event) {
      displayMessage('<strong>Mouseout Event</strong><br/>Start: ' + calEvent.start + '<br/>End: ' + calEvent.end);
    },
    noEvents: function() {
      displayMessage('There are no events for this week');
    },
    reachedmindate: function($calendar, date) {
      displayMessage('You reached mindate');
    },
    reachedmaxdate: function($calendar, date) {
      displayMessage('You cannot go further');
    }
  });

  function displayMessage(message) {
    $('#message').html(message).fadeIn();
  }

  $('<div id="message" class="ui-corner-all"></div>').prependTo($('body'));
});