"# MMU_FYP_WEB_APP" 
# Requirements Specifications

## 1. Functional Requirements

The FYP Management System provides the following functionalities:

- **Sign Up**: Students can register for an account by providing their personal and academic details.
- **Log In**: Students, Supervisors, and Admins can log into the system using their credentials.
- **Submit Proposals**: Students can submit project proposals for approval.
- **Submit Project**: Students upload their finalized project files for supervisor evaluation.
- **View Submitted Proposals**: Students and Supervisors can view the list of submitted project proposals.
- **View Submitted Projects**: Supervisors and Admins can view the finalized projects submitted by students.
- **Logout**: Users can securely logout from the system, ending their session.
- **View Meetings Details**: Students and Supervisors can view scheduled meetings and meeting details.
- **View Announcements**: All users can view important announcements made by Admins.
- **View Project Mark**: Students can view their project assessment marks.
- **Mark Submitted Projects**: Supervisors can assign grades to student projects after evaluation.
- **Set Up Meetings**: Supervisors can schedule meetings with their assigned students.
- **Assign Student to Project**: Supervisors can assign students to available project proposals.
- **Add Announcements**: Admins can create and post new announcements to the system.
- **Approve Submitted Proposals**: Admins review and approve submitted project proposals.
- **Reject Submitted Proposals**: Admins review and reject unsuitable project proposals with feedback.

---

## 2. Non-Functional Requirements

- **Security**: Passwords must be stored securely (hashed), and user sessions must be managed properly.
- **Performance**: System should handle at least 50 concurrent users without performance degradation.
- **Usability**: Interfaces should be simple and user-friendly for students, supervisors, and admins.
- **Compatibility**: Application should work smoothly on major modern browsers (Chrome, Firefox, Edge).
- **Maintainability**: The code should be modular and documented to ease future updates.

---

## 3. System Constraints

- Must use HTML, CSS, JavaScript for the client-side.
- Must use PHP for the server-side backend.
- Must use MySQL for database management.
- Must be hosted locally using XAMPP (Apache + MySQL).

---

## 4. User Roles

| Role | Description |
|------|-------------|
| **Student** | Can sign up, log in, submit proposals, submit final projects, view meetings, announcements, and marks. |
| **Supervisor** | Can log in, view proposals/projects, assign students, mark projects, set up meetings, and view announcements. |
| **Admin** | Can log in, approve/reject proposals, add announcements, manage users. |

---
