<!DOCTYPE html>
<html>

<head>
    <title>Performance Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 1rem;
        }

        .text-center {
            margin-bottom: 1rem;
        }

        .report-header,
        .report-section {
            margin-bottom: 1rem;
            padding: 0.5rem;
            border-bottom: 1px solid #dee2e6;
        }

        .report-header .header-item {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .report-header label,
        .report-section label {
            font-weight: bold;
            color: #495057;
            width: 160px;
            margin-right: 1rem;
        }

        .report-header span,
        .report-section span {
            color: #495057;
            flex: 1;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
            table-layout: fixed;
            /* Fixes the layout of the table */
        }

        .table th,
        .table td {
            vertical-align: middle;
            border: 1px solid #dee2e6;
            padding: 0.5rem;
            word-wrap: break-word;
            /* Ensures words break to fit within cell */
        }

        .table th {
            background-color: #f8f9fa;
            color: #343a40;
            font-weight: bold;
        }

        .text-end {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .no-column {
            width: 10%;
            /* Fixed width for 'No' column */
        }

        .project-name-column {
            width: 250px;
            /* Fixed width for 'Project Name' column */
        }

        .group-name-column {
            width: 150px;
            /* Fixed width for 'Group Name' column */
        }

        .date-column {
            width: 20%;
            /* Fixed width for 'Date' columns */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center">
            <h1 class="display-6">Performance Report</h1>
        </div>

        <div class="report-header">
            <div class="header-item">
                <label>Employee Name:</label>
                <span>{{ $employeeName }}</span>
            </div>
            <div class="header-item">
                <label>Evaluation Date:</label>
                <span>{{ $performances->evaluationDate }}</span>
            </div>
        </div>

        <div class="report-section">
            <h2>Performance Details</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th class="no-column">No</th>
                        <th>Indicator</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>Attendance Score</td>
                        <td>{{ $performances->attendanceScore }}</td>
                    </tr>
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>Communication Score</td>
                        <td>{{ $performances->communicationScore }}</td>
                    </tr>
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>Responsibility Score</td>
                        <td>{{ $performances->responsibilityScore }}</td>
                    </tr>
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>Quality of Work Score</td>
                        <td>{{ $performances->qualityWorkScore }}</td>
                    </tr>
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>Collaboration Score</td>
                        <td>{{ $performances->collaborationScore }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-end fw-bold">Total Score</td>
                        <td class="fw-bold">
                            {{ $performances->attendanceScore + $performances->communicationScore + $performances->responsibilityScore + $performances->qualityWorkScore + $performances->collaborationScore }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="report-section">
            <h2>Additional Details</h2>
            <table class="table">
                <tr>
                    <th style="width: 160px;">Description</th>
                    <td>{{ $performances->description }}</td>
                </tr>
                <tr>
                    <th style="width: 160px;">Notes</th>
                    <td>{{ $performances->notes }}</td>
                </tr>
            </table>
        </div>

        <div class="report-section">
            <h2>Project Details</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th class="no-column">No</th>
                        <th class="project-name-column">Project Name</th>
                        <th class="group-name-column">Group Name</th>
                        <th class="date-column">Start Date</th>
                        <th class="date-column">End Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $j = 1; ?>
                    @foreach ($groups as $group)
                        @if ($group->projects)
                            <tr>
                                <td>{{ $j++ }}</td>
                                <td>{{ $group->projects->projectName }}</td>
                                <td>{{ $group->groupName }}</td>
                                <td>{{ $group->projects->startDate }}</td>
                                <td>{{ $group->projects->endDate }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
