$(document).ready(function () {
  // console.log($('.input-datepicker'));
  if ($('.input-datepicker').each(function () {
    elem = this;

    // The lines below are executed on page load
    $('.input-datepicker').each(function () {
      checkForInput(this);
    });

    // The lines below (inside) are executed on change & keyup
    $('.input-datepicker').on('change keyup', function () {
      checkForInput(this);
    });

    function checkForInput(element) {
      // element is passed to the function ^

      const $div = $(element).closest('div');

      if ($(element).val().length > 0) {
        $div.addClass('has-value');
      } else {
        $div.removeClass('has-value');
      }
    }

    const datepicker = new Datepicker(elem, {

      // Whether or not to close the datepicker immediately when a date is selected.
      autohide: true,

      // Whether or not to show week numbers to the left of week rows.
      calendarWeeks: false,

      // If true, displays a "Clear" button at the bottom of the datepicker to clear the input value.
      // If 'autoclose' is also set to true, this button will also close the datepicker.
      clearBtn: false,

      // Delimiter string to separate the dates in a multi-date string.
      dateDelimiter: ',',

      // Array of date strings or a single date string formatted in the given date format.
      datesDisabled: [],

      // Days of the week that should be disabled.
      // Values are 0 (Sunday) to 6 (Saturday).
      // Multiple values should be comma-separated.
      // Example: disable weekends: '06' or '0,6' or[0, 6].
      daysOfWeekDisabled: [],

      // Days of the week that should be highlighted. Values are 0 (Sunday) to 6 (Saturday).
      daysOfWeekHighlighted: [],

      // Date to view when initially opening the calendar.
      // Date, String or Object with keys year, month, and day.
      // Defaults to today() by the program
      defaultViewDate: undefined,

      // If true, no keyboard will show on mobile devices.
      disableTouchKeyboard: false,

      // Date format string.
      // format: 'dd. mm. yyyy',
      format: 'yyyy-mm-dd',

      // The date format, combination of d, dd, D, DD, m, mm, M, MM, yy, yyyy.
      language: 'cs',

      // Maximum limit to selectable date. No limit is applied if null is set.
      maxDate: null,

      // Maximum number of dates users can select. No limit is applied if 0 is set.
      maxNumberOfDates: 1,

      // Muximum limit to the view that the date picker displayes. 0:days – 3:decades.
      maxView: 3,

      // Minimum limit to selectable date. No limit is applied if null is set.
      minDate: null,

      // HTML (or plain text) for the button label of the "Next" and "Prev" button.
      nextArrow: '»',
      prevArrow: '«',

      // left|right|auto for horizontal and top|bottom|auto for virtical.
      orientation: 'auto',

      // Whether or not to show the day names of the week.
      showDaysOfWeek: true,

      // If false, the datepicker will be prevented from showing when the input field associated with it receives focus.
      showOnFocus: true,

      // The view that the datepicker should show when it is opened.
      // Accepts: 0 or "days" or "month", 1 or "months" or "year", 2 or "years" or "decade", 3 or "decades" or "century", and 4 or "centuries" or "millenium".
      // Useful for date-of-birth datepickers.
      startView: 0,

      // The string that will appear on top of the datepicker. If empty the title will be hidden.
      title: '',

      // If true or "linked", displays a "Today" button at the bottom of the datepicker to select the current date.
      // If true, the "Today" button will only move the current date into view;
      // if "linked", the current date will also be selected.
      todayBtn: false,

      // 0  focus Move the focused date to the current date without changing the selection
      // 1 select  Select (or toggle the selection of) the current date
      todayBtnMode: 0,

      // If true, highlights the current date.
      todayHighlight: true,

      // Day of the week start. 0 (Sunday) to 6 (Saturday)
      weekStart: 0,

      // A function that takes a date as a parameter and returns one of the following values:
      beforeShowDay: function (date) {
        /* Return:
  {Object} - Things to customize. Available properties are:
   enabled: {Boolean} - whether the cell is selctable
   classes: {String} - space-sparated additional CSS classes for the cell element
   content: {String} - HTML for the cell element's child nodes
  {String} - additional classes — same as returning { classes: additionalClasses }
  {Boolean} - whether the cell is selctable — same as returning { enabled: isSelectable }
  /*
  }
  beforeShowDecade: function(date){
  /* Return:
  {Object} - Things to customize. Available properties are:
   enabled: {Boolean} - whether the cell is selctable
   classes: {String} - space-sparated additional CSS classes for the cell element
   content: {String} - HTML for the cell element's child nodes
  {String} - additional classes — same as returning { classes: additionalClasses }
  {Boolean} - whether the cell is selctable — same as returning { enabled: isSelectable }
  /*
  }
  beforeShowMonth: function(date){
  /* Return:
  {Object} - Things to customize. Available properties are:
   enabled: {Boolean} - whether the cell is selctable
   classes: {String} - space-sparated additional CSS classes for the cell element
   content: {String} - HTML for the cell element's child nodes
  {String} - additional classes — same as returning { classes: additionalClasses }
  {Boolean} - whether the cell is selctable — same as returning { enabled: isSelectable }
  /*
  }
  beforeShowYear: function(date){
  /* Return:
  {Object} - Things to customize. Available properties are:
   enabled: {Boolean} - whether the cell is selctable
   classes: {String} - space-sparated additional CSS classes for the cell element
   content: {String} - HTML for the cell element's child nodes
  {String} - additional classes — same as returning { classes: additionalClasses }
  {Boolean} - whether the cell is selctable — same as returning { enabled: isSelectable }
  */
      }
    });
  }));

  // HTML for range datepicker
  // <div id="range">
  //     <input type="text" name="start">
  //     <span>To</span>
  //     <input type="text" name="end">
  // </div>

  // const range = document.getElementById('range');
  // const dateRangePicker = new DateRangePicker(range, {

  //     // Whether to allow one side of the date-range to be blank.
  //     allowOneSidedRange: false,

  //     // Input fields to attach start- and end-date pickers. Must contain 2 items.
  //     // input: input

  // });

  // // Determines if the date picker is shown
  // Datepicker.active

  // // Adds new locals
  // Datepicker.locales.en = {
  //   days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
  //   daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
  //   daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
  //   months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
  //   monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
  //   today: "Today",
  //   clear: "Clear",
  //   titleFormat: "MM y",
  //   format: "mm/dd/yyyy",
  //   weekstart: 0
  // }

  // // Formats a date
  // Datepicker.formatDate(date, format, lang);

  // // Parses date strings
  // Datepicker.parseDate(dateStr, format, lang);

  // // Shows the date picker
  // instance.show();

  // // Hides the date picker
  // instance.show();

  // // Shows the date picker
  // instance.show();

  // // Refreshes a date picker
  // instance.refresh(target);

  // // Destroys the date picker
  // instance.destroy();

  // // Updates the date picker
  // instance.update(options);

  // // Updates options
  // instance.setOptions(options);

  // // Sets selected date(s)
  // instance.setDate( date1 [, date2 [, ... dateN ]][, options ] );
  // instance.setDate( dates [, options ] );
  // instance.setDate( [ options ] );

  // // Returns a Date object of selected date
  // instance.getDate(format);

  // // Updates options of the date range picker
  // rangepicker.setOptions(options);

  // // Get the start and end dates of the date range picker
  // rangepicker.getDate(format);

  // // Destroys the date range picker
  // rangepicker.destory();

  // instance.addEventListener('changeDate', function (e, details) {
  //     /* details:
  //     date: {Date} - Selected date(s) (see getDate())
  //     viewDate: {Date} - Focused date
  //     viewMode: {Number} - ID of the current view
  //     datepicker: {Datepicker} - Datepicker instance
  //     */
  // });

  // instance.addEventListener('changeMonth', function (e, details) {
  //     /* details:
  //     date: {Date} - Selected date(s) (see getDate())
  //     viewDate: {Date} - Focused date
  //     viewMode: {Number} - ID of the current view
  //     datepicker: {Datepicker} - Datepicker instance
  //     */
  // });

  // instance.addEventListener('changeView', function (e, details) {
  //     /* details:
  //     date: {Date} - Selected date(s) (see getDate())
  //     viewDate: {Date} - Focused date
  //     viewMode: {Number} - ID of the current view
  //     datepicker: {Datepicker} - Datepicker instance
  //     */
  // });

  // instance.addEventListener('changeYear', function (e, details) {
  //     /* details:
  //     date: {Date} - Selected date(s) (see getDate())
  //     viewDate: {Date} - Focused date
  //     viewMode: {Number} - ID of the current view
  //     datepicker: {Datepicker} - Datepicker instance
  //     */
  // });

  // instance.addEventListener('hide', function (e, details) {
  //     /* details:
  //     date: {Date} - Selected date(s) (see getDate())
  //     viewDate: {Date} - Focused date
  //     viewMode: {Number} - ID of the current view
  //     datepicker: {Datepicker} - Datepicker instance
  //     */
  // });

  // instance.addEventListener('show', function (e, details) {
  //     /* details:
  //     date: {Date} - Selected date(s) (see getDate())
  //     viewDate: {Date} - Focused date
  //     viewMode: {Number} - ID of the current view
  //     datepicker: {Datepicker} - Datepicker instance
  //     */
  // });
});