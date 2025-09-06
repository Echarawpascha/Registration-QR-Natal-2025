# Panitia Implementation TODO

## Phase 1: Core Setup
- [x] Create Panitia model
- [x] Create panitias table migration with approval_status
- [x] Add panitia guard and provider to auth.php
- [x] Create PanitiaAuthController
- [x] Add panitia routes to web.php

## Phase 2: Views and UI
- [x] Create panitia/login.blade.php
- [x] Create panitia/register.blade.php
- [x] Create panitia/dashboard.blade.php
- [x] Create panitia/pending.blade.php

## Phase 3: Attendance System
- [x] Create Attendance model
- [x] Create attendances table migration
- [x] Add barcode scanning to panitia dashboard
- [x] Implement attendance recording logic

## Phase 4: Admin System
- [x] Create Admin model
- [x] Create admins table migration
- [x] Add admin guard and provider
- [x] Create admin approval routes and views
- [x] Update panitia registration to require approval

## Testing
- [x] Test panitia registration flow
- [x] Test panitia login
- [x] Test barcode scanning
- [x] Test attendance tracking
- [x] Test admin approval workflow
