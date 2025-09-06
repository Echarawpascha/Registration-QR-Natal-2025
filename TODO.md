# TODO: Add Church Origin to Peserta Registration and Attendance

## Tasks
- [x] Create migration to add `church_origin` column to `pesertas` table
- [x] Update Peserta model to include `church_origin` in fillable
- [x] Update registration form to include church origin select field
- [x] Update PesertaAuthController to validate and save church_origin
- [x] Update attendance list view to include "Asal Gereja" column
- [x] Update AttendanceController to include church_origin in attendance data
- [x] Update attendance PDF to include church origin
