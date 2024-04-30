# Changelog

All notable changes to this project will be documented in this file.

## [0.6.1] - 2024-04-30
### Changed
- Callback's callback can now return a ValidationError to customize validation errors

## [0.6.0] - 2024-04-24
### Changed
- Map constraint can now allow specific missing fields when using Map::allowMissing(\['field'])
- Map constraint can now allow specific extra fields when using Map::allowExtra(\['field'])
- Map no longer sends null to validator when missing a field with allowMissing

## [0.5.0] - 2024-04-15
### Added
- ValidationReport and ValidationError classes to easily manage and receive information about errors thrown
- New Callback validator receiving a user defined callback that returns true/false for success or failure
- New DateFormat validator to validate a string to a date format

### Changed
- ConstraintInterface::validate() return value is now a ValidationReport
- All validators have a default error message
- All error messages can be changed using their ::setErrorMessage() method
- Bumped PHP compatibility version to PHP 8+

## [0.4.1]
### Added
- Stringable, Traversable and Scalar to Type constraint

## [0.4.0]
### Changed
- The whole API now works by returning true/false or message instead of an Errors object

### Added
- Unit tests

### Removed
- Translations
- Error Parser
- Errors class

## [0.3.0]
### Added
- Translations

## [0.2.2]
### Added
- Documentation
- Changelog