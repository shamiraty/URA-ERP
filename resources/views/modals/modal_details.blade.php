

<!-- Modal for Viewing Enquiry Details -->
<div class="modal fade" id="viewDetailsModal-{{ $enquiry->id }}" tabindex="-1" aria-labelledby="viewDetailsModalLabel-{{ $enquiry->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">  <!-- Use modal-xl for extra large modal -->
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title text-uppercase text-white" id="viewDetailsModalLabel-{{ $enquiry->id }}">Enquiry Details: {{ $enquiry->full_name }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <!-- Column for Details within a Card -->
                    <div class="row">


                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">Details</div>
                            <div class="card-body">
                            <ul class="list-group">
    <li class="list-group-item d-flex justify-content-between">
        <strong>Date Received:</strong>
        <span>{{ $enquiry->getDateReceivedAttribute($enquiry->date_received) }}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between">
        <strong>Full Name:</strong>
        <span>{{ $enquiry->full_name }}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between">
        <strong>Force Number:</strong>
        <span>{{ $enquiry->force_no }}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between">
        <strong>Check Number:</strong>
        <span>{{ $enquiry->check_number }}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between">
        <strong>Account Number:</strong>
        <span>{{ $enquiry->account_number }}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between">
        <strong>Bank Name:</strong>
        <span>{{ $enquiry->bank_name }}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between">
        <strong>District:</strong>
        <span>{{ $enquiry->district->name ?? 'No District' }}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between">
        <strong>Phone Number:</strong>
        <span>{{ $enquiry->phone }}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between">
        <strong>Region:</strong>
        <span>{{ $enquiry->region->name ?? 'No Region' }}</span>
    </li>
    {{-- <p>Region: {{ $enquiry->region->name ?? 'No Region' }}</p>
    <p>District: {{ $enquiry->district->name ?? 'No District' }}</p> --}}
    <li class="list-group-item d-flex justify-content-between">
        <strong>Type of Enquiry:</strong>
        <span>{{ $enquiry->type }}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between">
        <strong>Status:</strong>
        <span>{{ $enquiry->status }}</span>
    </li>
    @include('enquiries.partials.type_details', ['enquiry' => $enquiry])

    @if ($enquiry->payment)
        <li class="list-group-item d-flex justify-content-between">
            <strong>Payment Status:</strong>
            <span>{{ $enquiry->payment->status }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <strong>Payment Amount:</strong>
            <span>${{ number_format($enquiry->payment->amount, 2) }}</span>
        </li>
    @else
        <li class="list-group-item d-flex justify-content-between">
            <strong>No Payment Details Available</strong>
        </li>
    @endif
</ul>

                            </div>
                        </div>
                    </div>
                    <!-- Column for Attachment View within a Card -->
                    {{-- <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">Attachments</div>
                            <div class="card-body">
                                @if ($enquiry->file_path)
                                    <object data="{{ asset($enquiry->file_path) }}" type="application/pdf" width="100%" height="400px" class="border rounded">
                                        <p class="text-muted">Your browser does not support PDFs.
                                            <a href="{{ asset($enquiry->file_path) }}" class="text-decoration-underline">Download the PDF</a>.
                                        </p>
                                    </object>
                                @else
                                <div class="alert border-0 border-start border-5 border-warning alert-dismissible fade show py-2">
									<div class="d-flex align-items-center">
										<div class="font-35 text-warning"><i class='bx bx-info-circle'></i>
										</div>
										<div class="ms-3">
											<div>No file uploaded.</div>
										</div>
									</div>
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>
                                @endif
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">Attachments</div>
                            <div class="card-body">
                                @if ($enquiry->folios->isNotEmpty())
                                    @foreach ($enquiry->folios as $folio)
                                        @php
                                            $extension = strtolower(pathinfo($folio->file_path, PATHINFO_EXTENSION));
                                        @endphp

                                        @if ($extension === 'pdf')
                                            <!-- Embedded PDF preview -->
                                            <div class="mb-4">
                                                <object data="{{ asset($folio->file_path) }}" type="application/pdf" width="100%" height="400px" class="border rounded">
                                                    <p class="text-muted">Your browser does not support PDFs.
                                                        <a href="{{ asset($folio->file_path) }}" class="text-decoration-underline">Download the PDF</a>.
                                                    </p>
                                                </object>
                                                {{-- <p class="mt-2">
                                                    <a href="{{ asset($folio->file_path) }}" class="btn btn-primary" target="_blank">Download PDF</a>
                                                </p> --}}
                                            </div>
                                        @elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                            <!-- Display image -->
                                            <div class="mb-4">
                                                <img src="{{ asset($folio->file_path) }}" alt="Attachment Image" class="img-fluid border rounded">
                                                {{-- <p class="mt-2">
                                                    <a href="{{ asset($folio->file_path) }}" class="btn btn-primary" target="_blank">Download Image</a>
                                                </p> --}}
                                            </div>
                                        @else
                                            <!-- Fallback for other file types -->
                                            <div class="mb-4">
                                                <p class="text-muted">Attachment: {{ basename($folio->file_path) }}</p>
                                                <a href="{{ asset($folio->file_path) }}" class="btn btn-primary" target="_blank">Download File</a>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="alert alert-warning">
                                        <div class="d-flex align-items-center">
                                            <div class="font-35 text-warning me-3"><i class='bx bx-info-circle'></i></div>
                                            <div>
                                                <strong>No files uploaded.</strong>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>