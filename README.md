# My Findings
> as mentioned in readme.txt I categorize my thoughts in
> below 3 points:

`NOTE`: I have NOT refectored the entire code, instead do some functions/methods to just highlight the better way of doing it, which of course need to apply in different places.


1. Amazing
===========
OOP
Usage on MC from MVC pattern for the application data and business logic.


2. Ok
=======
Function & Code comments
used TODOs in a few places.
Extra line of commented code, BUT need TODO tag for future removal or re-usability.


3. Terrible
============
Validating REQUEST data inside controller are not best practice specially with large data validation, it should be separate FormRequest class to handle.(BookingRequest/JobRequest)

Not following SOLID principle (code repetition), although MVC is used but it is not following the SOLID principle rule, logic is written in controller file.

Classes/Function are not based on Single Responsibility of (SOLID) principle. which need to be broken into different Traits/Interfaces for neat and clean code and re-usability.

Direct usage on Database Query from Controller plus poor variable naming. ($affectedRows1 = Job::where('id', '=', $jobid)....)

Bellow objects should be Wrapper Model so that they could be easily reused for other Repositories.
and used in BookingRepository like `$job->storeEmail(), $job->toData(), and $job->end()`
Jobs/Notifications/Mailers/SMS

`Statuses` - could be a Trait.

`userLoginFailed` - this function should be part of the user authentication class and called in BookingRepository.

`convertToHoursMins`- this function should be part of the Helper class which can be used globally in the project.

Obvious and consistent names are important, naming like @endJob vs jobEnd() are confusing.

Hardcoded strings are used in code instead of Constants. ($job->status == 'pending')

Localization/Language-file are not used.($subject = 'Bekräftelse - tolk har accepterat er bokning');

Not following the same principle for variable naming. (my_var vs myVar, $totaljobs vs $noramlJobs)

Declared extra variables in different functions which are never used.

Date formatting should be part of the Helper functions, to manage date format globally in a project.

Almost every function in BookingRepository could be half of the number of lines if properly used IF/ELSE conditions.

Notifications & Responses should be templated (via helper) instead of writing it directly in the Controller.
