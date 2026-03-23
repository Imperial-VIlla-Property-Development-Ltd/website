<!doctype html>
<html><head><meta charset="utf-8"><title>Staff Report</title></head>
<body>
<h2>Staff Report #{{ $report->id }}</h2>
<p><strong>Staff ID:</strong> {{ $report->staff_id }}</p>
<p><strong>Date:</strong> {{ $report->report_date }}</p>
<p><strong>Content:</strong></p>
<p>{{ $report->content }}</p>
</body></html>
