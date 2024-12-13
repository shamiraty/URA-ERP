

  <aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
      <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div class="bg-primary">
      <a href="{{ route('dashboard') }}" class="sidebar-logo">
       {{-- <img src="{{ asset('assets/images/uralogo.pn') }}" alt="CRM " class="light-logo">
        <img src="{{ asset('assets/images/uralogo-light.pn') }}" alt="CRM" class="dark-logo">
        <img src="{{ asset('assets/images/uralogo-icon.pn') }}" alt="CRM" class="logo-icon">--}}
        <h5 class="text-white">CRM</h5>
      </a>
    </div>
    <div class="sidebar-menu-area">
      <ul class="sidebar-menu" id="sidebar-menu">
        <li>
          <a href="{{ route('dashboard') }}">
            <iconify-icon icon="bx:bx-home-alt" class="menu-icon"></iconify-icon>
            <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="{{ route('enquiries.my') }}">
            <iconify-icon icon="bx:bx-folder" class="menu-icon"></iconify-icon>
            <span>My Enquiries</span>
          </a>
        </li>

        @if(auth()->user()->hasRole(['Registrar', 'general_manager', 'assistant_general_manager', 'superadmin','system_admin']))
        <li class="dropdown">
          <a href="javascript:void(0)">
            <iconify-icon icon="bx:bx-category" class="menu-icon"></iconify-icon>
            <span>Enquiries Management</span>
          </a>
          <ul class="sidebar-submenu">
            <li>
              <a href="{{ route('enquiries.create') }}">
                <iconify-icon icon="bx:bx-plus-circle"></iconify-icon> New Enquiry
              </a>
            </li>
            <li>
              <a href="{{ route('enquiries.index') }}">
                <iconify-icon icon="bx:bx-folder"></iconify-icon> All Enquiries
              </a>
            </li>
            @if(!auth()->user()->hasRole('Registrar'))
            <li>
  <a href="{{ route('enquiries.index', ['type' => 'loan_application']) }}">
    <iconify-icon icon="mdi:arrow-right"></iconify-icon> Loan Applications
  </a>
</li>
<li>
  <a href="{{ route('enquiries.index', ['type' => 'share_enquiry']) }}">
    <iconify-icon icon="mdi:arrow-right"></iconify-icon> Share Enquiries
  </a>
</li>
<li>
  <a href="{{ route('enquiries.index', ['type' => 'retirement']) }}">
    <iconify-icon icon="mdi:arrow-right"></iconify-icon> Retirement Enquiries
  </a>
</li>
<li>
  <a href="{{ route('enquiries.index', ['type' => 'deduction_add']) }}">
    <iconify-icon icon="mdi:arrow-right"></iconify-icon> Deduction Adjustment
  </a>
</li>
<li>
  <a href="{{ route('enquiries.index', ['type' => 'refund']) }}">
    <iconify-icon icon="mdi:arrow-right"></iconify-icon> Refund Enquiries
  </a>
</li>
<li>
  <a href="{{ route('enquiries.index', ['type' => 'withdraw_savings']) }}">
    <iconify-icon icon="mdi:arrow-right"></iconify-icon> Withdraw
  </a>
</li>
<li>
  <a href="{{ route('enquiries.index', ['type' => 'join_membership']) }}">
    <iconify-icon icon="mdi:arrow-right"></iconify-icon> Join Membership
  </a>
</li>
<li>
  <a href="{{ route('enquiries.index', ['type' => 'unjoin_membership']) }}">
    <iconify-icon icon="mdi:arrow-right"></iconify-icon> Unjoin Membership
  </a>
</li>
<li>
  <a href="{{ route('enquiries.index', ['type' => 'benefit_from_disasters']) }}">
    <iconify-icon icon="mdi:arrow-right"></iconify-icon> Benefit from Disasters
  </a>
</li>
<li>
  <a href="{{ route('enquiries.index', ['type' => 'sick_for_30_days']) }}">
    <iconify-icon icon="mdi:arrow-right"></iconify-icon> Sick 30 Days
  </a>
</li>
<li>
  <a href="{{ route('enquiries.index', ['type' => 'condolences']) }}">
    <iconify-icon icon="mdi:arrow-right"></iconify-icon> Condolences
  </a>
</li>
<li>
  <a href="{{ route('enquiries.index', ['type' => 'injured_at_work']) }}">
    <iconify-icon icon="mdi:arrow-right"></iconify-icon> Work Injury
  </a>
</li>


            @endif
          </ul>
        </li>
        @endif

        @if(auth()->user()->hasAnyRole(['loanofficer', 'general_manager', 'assistant_general_manager', 'superadmin','system_admin']))
        <li class="dropdown">
          <a href="javascript:void(0)">
            <iconify-icon icon="bx:bx-category" class="menu-icon"></iconify-icon>
            <span>Loan Management</span>
          </a>
          <ul class="sidebar-submenu">
            <li>
              <a href="{{ route('mortgage.form') }}">
                <iconify-icon icon="bx:bx-calculator"></iconify-icon> Calculator
              </a>
            </li>
            <li>
              <a href="{{ route('members.processedLoans') }}">
                <iconify-icon icon="bx:bx-time"></iconify-icon> Pending Loan
              </a>
            </li>
            <li>
              <a href="#">
                <iconify-icon icon="bx:bx-block"></iconify-icon> Rejected Loan
              </a>
            </li>
            <li>
              <a href="#">
                <iconify-icon icon="bx:bx-money"></iconify-icon> Payment Loan
              </a>
            </li>
            <li>
              <a href="#">
                <iconify-icon icon="bx:bx-check-circle"></iconify-icon> Approved Loan
              </a>
            </li>
            <li>
              <a href="#">
                <iconify-icon icon="bx:bx-dollar-circle"></iconify-icon> Interest
              </a>
            </li>
            <li>
              <a href="{{ route('members.uploadForm') }}">
                <iconify-icon icon="bx:bx-upload"></iconify-icon> Upload Loan Application
              </a>
            </li>
            <li>
              <a href="#">
                <iconify-icon icon="bx:bx-check"></iconify-icon> Processed Loans
              </a>
            </li>
          </ul>
        </li>
        @endif

        @if(auth()->user()->hasAnyRole(['accountant', 'general_manager', 'assistant_general_manager', 'superadmin','system_admin']))
        <li class="dropdown">
          <a href="javascript:void(0)">
            <iconify-icon icon="bx:bx-bookmark-heart" class="menu-icon"></iconify-icon>
            <span>Payments Management</span>
          </a>
          <ul class="sidebar-submenu">
            <li class="{{ request()->is('payments/refund') ? 'active' : '' }}">
              <a href="{{ route('payments.type', ['type' => 'refund']) }}">
                <iconify-icon icon="bx:bx-undo"></iconify-icon> Refund
              </a>
            </li>
            <li class="{{ request()->is('payments/retirement') ? 'active' : '' }}">
              <a href="{{ route('payments.type', ['type' => 'retirement']) }}">
                <iconify-icon icon="bx:bx-user-check"></iconify-icon> Retirement
              </a>
            </li>
            <li class="{{ request()->is('payments/withdraw_savings') ? 'active' : '' }}">
              <a href="{{ route('payments.type', ['type' => 'withdraw_savings']) }}">
                <iconify-icon icon="bx:bx-money-withdraw"></iconify-icon> Withdraw Savings
              </a>
            </li>
            <li class="{{ request()->is('payments/benefit_from_disasters') ? 'active' : '' }}">
              <a href="{{ route('payments.type', ['type' => 'benefit_from_disasters']) }}">
                <iconify-icon icon="bx:bx-support"></iconify-icon> Benefit from Disasters
              </a>
            </li>
            <li class="{{ request()->is('payments/deduction_add') ? 'active' : '' }}">
              <a href="{{ route('payments.type', ['type' => 'deduction_add']) }}">
                <iconify-icon icon="bx:bx-plus"></iconify-icon> Deduction Adjustment
              </a>
            </li>
            <li class="{{ request()->is('payments/share_enquiry') ? 'active' : '' }}">
              <a href="{{ route('payments.type', ['type' => 'share_enquiry']) }}">
                <iconify-icon icon="bx:bx-share-alt"></iconify-icon> Share
              </a>
            </li>
            <li class="{{ request()->is('payments/withdraw_deposit') ? 'active' : '' }}">
              <a href="{{ route('payments.type', ['type' => 'withdraw_deposit']) }}">
                <iconify-icon icon="bx:bx-wallet"></iconify-icon> Withdraw Deposit
              </a>
            </li>
          </ul>
        </li>
        @endif

        @if(auth()->user()->hasRole(['general_manager', 'assistant_general_manager', 'superadmin','system_admin']))
        <li class="dropdown">
          <a href="javascript:void(0)">
            <iconify-icon icon="bx:bx-repeat" class="menu-icon"></iconify-icon>
            <span>Member Management</span>
          </a>
          <ul class="sidebar-submenu">
            <li>
              <a href="#">
                <iconify-icon icon="bx:bx-user-plus"></iconify-icon> New Member
              </a>
            </li>
            <li>
              <a href="#">
                <iconify-icon icon="bx:bx-group"></iconify-icon> Members
              </a>
            </li>
            <li>
              <a href="#">
                <iconify-icon icon="bx:bx-user-x"></iconify-icon> Unjoin Member
              </a>
            </li>
            <li>
              <a href="#">
                <iconify-icon icon="bx:bx-user-check"></iconify-icon> Retired Member
              </a>
            </li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="javascript:void(0)">
            <iconify-icon icon="bx:bx-shield" class="menu-icon"></iconify-icon>
            <span>Access Management</span>
          </a>
          <ul class="sidebar-submenu">
            <li>
              <a href="{{ route('roles.index') }}">
                <iconify-icon icon="bx:bx-user-pin"></iconify-icon> Roles
              </a>
            </li>
            <li>
              <a href="{{ route('permissions.index') }}">
                <iconify-icon icon="bx:bx-key"></iconify-icon> Permissions
              </a>
            </li>
            <li>
              <a href="{{ route('ranks.create') }}">
                <iconify-icon icon="bx:bx-key"></iconify-icon> Ranks
              </a>
            </li>
            <li>
              <a href="{{ route('users.index') }}">
                <iconify-icon icon="bx:bx-user"></iconify-icon> Users
              </a>
            </li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="javascript:void(0)">
            <iconify-icon icon="bx:bx-buildings" class="menu-icon"></iconify-icon>
            <span>Branch Management</span>
          </a>
          <ul class="sidebar-submenu">
            <li>
              <a href="{{ route('branches.index') }}">
                <iconify-icon icon="bx:bx-list-ul"></iconify-icon> List Branches
              </a>
            </li>
            <li>
              <a href="{{ route('branches.create') }}">
                <iconify-icon icon="bx:bx-plus-circle"></iconify-icon> Add Branch
              </a>
            </li>
            <li>
              <a href="{{ route('departments.index') }}">
                <iconify-icon icon="bx:bx-layer"></iconify-icon> Departments
              </a>
            </li>
            <li>
              <a href="{{ route('representatives.index') }}">
                <iconify-icon icon="bx:bx-user-pin"></iconify-icon> Representatives
              </a>
            </li>
            <li>
              <a href="{{ url('/posts/create') }}">
                <iconify-icon icon="bx:bx-plus-circle"></iconify-icon> Create Post
              </a>
            </li>
            <li>
              <a href="{{ route('payroll.showUpload') }}">
                <iconify-icon icon="bx:bx-user-pin"></iconify-icon> Import Payroll
              </a>
            </li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="javascript:void(0)">
            <iconify-icon icon="bx:bx-bar-chart" class="menu-icon"></iconify-icon>
            <span>Trends</span>
          </a>
          <ul class="sidebar-submenu">
            <li>
              <a href="{{ route('trends') }}">
                <iconify-icon icon="bx:bx-file-blank"></iconify-icon> Registered Enquiries
              </a>
            </li>
            <li>
              <a href="{{ route('loan_trends') }}">
                <iconify-icon icon="bx:bx-briefcase"></iconify-icon> Loan Applications
              </a>
            </li>
          </ul>
        </li>
        @endif

        <li class="dropdown">
          <a href="javascript:void(0)">
            <iconify-icon icon="bx:bx-archive" class="menu-icon"></iconify-icon>
            <span>Document Management</span>
          </a>
          <ul class="sidebar-submenu">
            <li>
              <a href="{{ route('files.index') }}">
                <iconify-icon icon="bx:bx-radio-circle"></iconify-icon> List Files
              </a>
            </li>
            <li>
              <a href="{{ route('files.create') }}">
                <iconify-icon icon="bx:bx-radio-circle"></iconify-icon> Create File
              </a>
            </li>
            <li>
              <a href="{{ route('file_series.index') }}">
                <iconify-icon icon="bx:bx-radio-circle"></iconify-icon> List File Series
              </a>
            </li>
            <li>
              <a href="{{ route('file_series.create') }}">
                <iconify-icon icon="bx:bx-radio-circle"></iconify-icon> Create File Series
              </a>
            </li>
            <li>
              <a href="{{ route('keywords.index') }}">
                <iconify-icon icon="bx:bx-radio-circle"></iconify-icon> List Keywords
              </a>
            </li>
            <li>
              <a href="{{ route('keywords.create') }}">
                <iconify-icon icon="bx:bx-radio-circle"></iconify-icon> Create Keyword
              </a>
            </li>
            <li>
              <a href="{{ route('keywords.showImportForm') }}">
                <iconify-icon icon="bx:bx-import"></iconify-icon> Import Keywords
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
</aside>

