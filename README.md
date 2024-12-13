# SYSTEM REQUIREMENTS
## 1. OTP MESSAGE


| Requirement            | Status |
|------------------------|--------|
| Enquiry registration    | ✔️     |
| Enquiry / Processing    | ✔️     |
| Enquiry Approval        | ✔️     |
| Enquiry Rejection       | ✔️     |
| Enquiry Payment         | ✔️     |

## 2. ACTION MODAL POPUP

### **Loan Officer**

| Action       | Modal Popup | Alert |
|--------------|-------------|-------|
| View Loan    | ✔️          | ✔️    |
| Process Loan | ✔️          | ✔️    |
| Approve Loan | ✔️          | ✔️    |
| Reject Loan  | ✔️          | ✔️    |

**Others:**
- When Rejected: Disable Process & Approve
- When Approved: Disable Reject & Process
- When Processed: Enable Reject and Process

### **Accountant**

| Action           | Modal Popup | Alert |
|------------------|-------------|-------|
| Initiate Payment  | ✔️          | ❌    |
| Approve Payment   | ✔️          | ✔️    |
| Pay Payment       | ✔️          | ✔️    |

### **Mahusiano**

| Action          | Modal Popup | Alert |
|-----------------|-------------|-------|
| View Detail     | ❌          |       |
| Assign          | ✔️          | ❌    |
| Edit            | ❌          | ❌    |
| Delete          | ❌          | ❌    |

## 3. DATA TABLES

### **ENQUIRY MANAGEMENT**

| Enquiry Type                     | Datatable |
|-----------------------------------|-----------|
| Loan application Enquiries        | ❌        |
| Share enquiry Enquiries           | ❌        |
| Retirement Enquiries              | ❌        |
| Withdraw savings Enquiries        | ❌        |
| Withdraw deposit Enquiries        | ❌        |
| Unjoin membership Enquiries       | ❌        |
| Benefit from disasters Enquiries   | ❌        |

### **LOAN MANAGEMENT**

| Loan Type                       | Datatable |
|----------------------------------|-----------|
| Processed Loan                  | ❌        |
| Rejected Loan                   | ❌        |
| Payment Loan                    | ❌        |
| Approved Loan                   | ❌        |

**Others:**
- _Incomplete Pages_
  - Rejected Loan 
  - Payment Loan 
  - Approved Loan 

### **PAYMENT MANAGEMENT**

| Payment Type                    | Datatable |
|----------------------------------|-----------|
| Refund                          | ❌        |
| Retirement                      | ❌        |
| Withdraw Savings                | ❌        |
| Benefit from Disasters          | ❌        |
| Deduction Adjustment            | ❌        |
| Share                           | ❌        |
| Withdraw Deposit                | ❌        |

### **MEMBER MANAGEMENT**

| Member Status                   | Datatable |
|----------------------------------|-----------|
| New Member                      | ❌        |
| Existing Member                 | ❌        |
| Unjoin Member                   | ❌        |
| Retired Member                  | ❌        |

### **ACCESS MANAGEMENT & ALERT MESSAGES**

| Access Type                    | Datatable | Alert                          |
|----------------------------------|-----------|--------------------------------|
| Roles datatable                 | ✔️        | Add, Delete, and Update Role❌   |
| Permissions Datatable           | ✔️        | Create Permission❌               |
| Users Datatable                 | ✔️        | Create User❌                     |

### **BRANCH MANAGEMENT & ALERT MESSAGE**

| Branch Function                | Datatable | Alert                          |
|----------------------------------|-----------|--------------------------------|
| List Branches                  | ❌        | Create, Edit & Delete Branch   |
| Departments                     | ❌        | Create, Edit & Delete Department|
| Representatives                 | ❌        | Add New Representative          |

## 4. RUNTIME EXCEPTIONS

| Exception Type                  |
|----------------------------------|
| Assignment of Share Enquiry     |
| Creating a New Role             |
| Editing a Branch                |
| Editing a Department            |
| Adding User (no Alert)           |

## 5. DUPLICATION OF UNIQUE RECORDS

| Record Type                     |
|----------------------------------|
| Adding a New Branch             |

## 6. UNSTYLED PAGES

| Page Type                       |
|----------------------------------|
| Add, Delete, View Representatives|

## 7. PENDING TASK

| Task Type                       |
|----------------------------------|
| Customization of Login Screen    |
| Session Management in web routing(Page Accessibility by Role )    |
| Display more information in the View Detail modal for Loans and other models where necessary|
| Two Factor aunthentication login OTP|
| Each Enquiry Registration must show created_by |
| Each register when Login, on MyEnquiry menu should show Enquiry he registered and their status  it includes  Loans  and all Enquiries types also simple analtics |
|Initiate Payment Alert and document validation PDF|


## 6. ADDITIONAL USER REQUIREMENTS & MODIFICATION

**On Create Enquiry template** 

| Enquiry Type         | Category                          | Status |
|----------------------|-----------------------------------|--------|
| Sick for 30 days      | -----                             | ❌     |
| Bereavement / Condolences | Dependent Member (female, male) | ❌     |
| Injured at Work       | -----                             | ❌     |
| Residential Disaster  | Fire, Hurricane, Flood, Earthquake| ❌     |
| New Membership        | Member, Not Member                | ❌     |
| Unjoin Membership     | Normal, Dismissed, Resigned       | ❌     |

**others**

| S/N | Requirement                                                                                                                                                   | Status |
|-----|---------------------------------------------------------------------------------------------------------------------------------------------------------------|--------|
| 1   | On "all enquiries" in the "View" modal, there should also be an action menu, including View, Assign, Edit, and Delete.                                         | ✔️     |
| 2   | In the Enquiry Assignment Popup Modal, remove users who are not responsible for assignment, such as representatives and registrars.                            | ❌     |
| 3   | On "all enquiries", add a column in the template table showing the assigned person and who registered that enquiry, to help others track the information. Make "Registered By" clickable to redirect to the user's profile.                                                         | ❌     |
| 4   | A staff member assigned to an enquiry should receive a notification via message.                                                                               | ❌     |
| 5   | Withdrawn savings can be stored in an archive for three months before being assigned to an accountant, but they should be assignable at any time.   "all enquiry"  to add another action/route/controller/view for achive   [ Logics for months  in Controller ]        | ❌     |
| 6   | A SweetAlert message should appear when deleting an enquiry in the "All Enquiries" section.                                                                         | ❌     |
| 7   | Representatives should register enquiries for their respective branches, and the branches should submit them to headquarters. This increases accountability and reduces the workload at headquarters, as branches will handle enquiries for their areas. /also or otherwise                                | ❌     |
| 8   | In "My Enquiries" for the Loan Officer, some variables are not visible on the View Modal.                                                                      | ❌     |
| 9   | In "My Enquiries" for the Accountant, the formula in the View Modal is providing incorrect analysis.                                                           | ❌     |
| 10  | Prepare a template filtering by Date range, status, Location, Enquiry Type, Assigned User and Registered by to display any type of enquiry that is Rejected, Pending, Processed, or Assigned, and also show the Enquiry history. Enable export buttons for Excel. | ❌     |
| 11  | In a template with a data table, enable export buttons based on Excel sheet columns for funeral benefits and savings deductions.                                | ❌     |
| 12  | On "Create Enquiry," add the Enquiry type 'New Membership' and   { 'Condolences' or 'RambiRambi' and include details of the deceased member as shown in the Excel sheet. /dependant  in the drop down list can be child, futher  etc  }       | ❌     |
| 13  | On "Create Enquiry," add a section for "Benefit from Disaster" with a dropdown to select the type of disaster, such as accident, illness, flood, etc., and create a template table with export buttons. | ❌     |
| 14  | On "Create Enquiry," for unjoining membership, add a dropdown for reasons such as: dismissal, resignation, or retirement.                                      | ❌     |



# 7. RECOMMENDED USER REQUIREMENTS

| Requirement                                                           |
|-----------------------------------------------------------------------|
| Remove Action Buttons for users who are not involved in their use     |
| Overdue Notifications for Pending, Rejected, Assigned, Processed items|
| Login Notifications                                                    |
| Customization of Notification Dialogs                                  |
| Warning Alerts for Each Action Performed by the User                  |
| Token for Users Who Approve Loans or Make Payments                    |
| OTP Messages Sent to Customers Must Include Tracking IDs               |
| OTP Messages for All Employees Assigned Tasks                          |
| Search Functionality on Tables by Date, Range, Account Number, or Names|
| Customization of Table Columns for CSV Exports                        |
| The Dashboard Must Include Simple Analysis for Pending, Assigned, Paid, etc.|
| OTP Token for Payment Approval                                         |
| Warning Alerts If Documents Are Missing in Modals                     |
| General Manager Should Prevent the Accountant from Making Payments If the Loan Is Rejected|
| Installments for Cash Loans                                           |
| In Trends, Remove "Sum" and Use "Amount"                             |
| In Trends, Show Pending and Paid Status for Each Loan                |
| In Regions, Change "Arusha Rula District" to "Arumeru"               |

## 8. OTHER RECOMMENDATIONS FROM GM

| Recommendation                                                       |
|-----------------------------------------------------------------------|
| Provide education on how to Register in the ESS System                |
| Provide education on how to Apply for Loans                           |
| Provide education on Loan Products                                    |
| Review Existing Loan Options and Make Comparisons                    |
| Educate on the Importance or Benefits of Borrowing from URA SACCOS Compared to Other Institutions |
| Educate on the Benefits of ESS Membership for SACCOS Members         |
| Establish a Desk at Police Headquarters to Assist with Email Access and Corrections |
