<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommendations Tracking Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>

        body {
            font-family: Arial, sans-serif;
        }

        .letter-section, .introduction-section,
        .critial-recommendations,
        .conclusion-section, .recommendations-details,
        .appendix, .page1,
        .conclusion, .unresolved-recommendations {
            page-break-before: always;
        }

        .title-page {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }

        img {
            display: block;
            margin: 20px auto;
        }

        h1 {
            font-size: 20pt;
            font-weight: bold;
        }

        h2 {
            font-size: 18pt;
            font-weight: bold;
            text-align: center;
        }

        h3 {
            font-size: 18pt;
            font-weight: bold;
            /* text-align: center; */
        }

        h4 {
            font-size: 18pt;
            /* text-align: center; */
        }

        p {
            font-size: 15pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        @page {
            margin: 100px 25px;
        }

        #page-footer {
            position: fixed;
            bottom: 0;
            border-top: 0.1pt solid #aaa;
            text-align: center;
            width: 100%;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }

        #page-footer .page-number:before {
            content: counter(page);
        }

        /* Define a landscape page size */
        @page landscape {
            size: A3 landscape;
            margin: 50px;
        }

        /* Apply landscape page size to specified sections */
        .landscape-section {
            page: landscape;
        }

        img {
            display: block;
            margin: 20px auto;
            max-width: 100%;
            height: 500px;
        }
    </style>

    
</head>

<body>
    <titlepage class="page1">
        <div class="title-page">
            <h1>REPORT OF THE AUDITOR-GENERAL</h1>
            <h2>Analysis of Audit Recommendations</h2>
            <h2>{{ $countryName }}</h2>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <h4>Location: {{ $location }}</h4>
        <h4>Postal Address: {{ $postalAddress }}</h4>
        <h4>Telephone: {{ $telephone }}</h4>
        <h4>Email: {{ $email }}</h4>
        <h4>Website: {{ $website }}</h4>
    </titlepage>

    <div class="letter-section">
        <h1>Date: <?php echo date('F j, Y'); ?></h1>
        <p>
            <h1>Parliament of {{ $countryName }} </h1>
            <p>{{ $postalAddress }}</p>
        </p>
        <p>Dear Sir/Madam,</p>
        <p>The Supreme Audit Institution is pleased to submit this report to Parliament on the current state of recommendation tracking. This report is a critical component of ensuring accountability and effective public financial management.</p>
        <p>This report details the existing recommendation tracking system, including the current implementation rate and trends. Importantly, the report includes a list of outstanding recommendations arising from past audits.  This list will provide Parliament with a clear understanding of the areas where continued action is needed.</p>
        <p>The SAI believes that strengthening the recommendation tracking system is essential.  </p>
        <p>The SAI welcomes the opportunity to discuss this report and its recommendations further with relevant parliamentary committees. We also stand ready to collaborate with Parliament on developing an action plan to implement the proposed improvements.</p>
        <p>Sincerely,</p>
        <p class="">{{ $headOfSAI }} <br>
            {{ $tool->tool_name }} Office of the Auditor General
        </p>
    </div>

    <div class="introduction-section">
        <h1>Introduction</h1>
        <h3>What is an Audit?</h3>
        <p>
            An audit is a check-up or inspection for the money that the government or organizations have. It's done to make sure that the money is being used properly and that everything is recorded correctly. Auditors are like detectives who investigate the money to see if everything is honest, transparent, and follows the rules.
        </p>
        
        <h3>The Audit Process</h3>
        <!-- Updated Implementation Status section -->
        <p>
            1. Planning <br>
            Before the audit starts, the auditors get to know the organization and its money systems. They plan for how they will do the audit and what areas they will look at more closely
        </p>

        <p>
            2. Risk Assessment <br>
            Auditors think about the risks or problems that might happen with the money. They look for any signs of mistakes, fraud, or things that don't follow the rules. This helps them focus on the important areas that need extra attention.
        </p>

        <p>
            3. Fieldwork <br>
            This is when the auditors do their investigation. They look at documents, talk to people, and do some calculations to make sure the money is recorded correctly. They check if the money was spent in the right way and if there are any problems.
        </p>

        <p>
            4. Reporting <br>
            After the investigation, the auditors write a report to explain what they found. They say if the money is being handled well and if everything is recorded properly. If there are any concerns or mistakes, they will tell about them in the report.
        </p>

        <p>
            5. Follow-up and Monitoring <br>
            After the audit, the auditors may give suggestions on how to improve the money systems. It's up to the organization to fix any mistakes and make things better. The auditors may check back later to make sure the improvements are being done.
        </p>
        <div class="types-of-audits">
            <h3>Types of Audits: Financial, Performance, Compliance</h3>
            <h3>1.	Financial Audit</h3>
            <p>
                A financial audit is like a health check for an organization's money. It's similar to when we go to the doctor to make sure our body is healthy. In a financial audit, experts called auditors carefully look at all the money-related records of a government agency or project. They want to ensure that the money is managed properly and follows the rules that are important for good financial management. <br> <br>
                For example, imagine a fishing project that receives money from the government. A financial audit would check if the project's money were being spent on the right things, if the income and expenses are recorded correctly, and if the project is following the financial rules set by the government.
            </p>

            <h3>2.	Performance Audit</h3>
            <p>
                A performance audit is like an assessment of how well a government agency or project is doing its job. It's like a report card that tells us if they are achieving their goals and using resources wisely. Performance auditors want to make sure that the government agency or project is effective, effi¬cient, and making a positive impact in the community. They look at things like whether the services provided are helpful, if the money is used effi¬ciently, and if the goals set by the government are being achieved. <br> <br>
                For example, let's say there's a health clinic. A performance audit would evaluate if the clinic were providing good healthcare services, if the resources like medicines and equipment are used efficiently, and if the clinic is meeting the health targets set by the government.
             </p>

            <h3>3.	Compliance Audit</h3>
            <p>
                A compliance audit is like checking if an organization or project is following the rules and laws. It's similar to when we play a game and need to follow the rules to make it fair. Compliance auditors make sure that government agencies and projects are obeying the laws, regulations, and policies that apply to them. They want to ensure that everyone is treated fairly, the money is spent properly, and the actions are in line with what the government expects. <br> <br>
                For example, let's imagine there's a construction project. A compliance audit would make sure that the project is following the construction rules and regulations, that the materials used are of good quality, and that the workers are safe and protected.
            </p>
        </div>
        <h1>Why are Audits Important?</h1>
        <p>In the Pacific, audits are especially important because they help ensure that the limited resources we have are used in the best way possible. They promote transparency, accountability, and good governance, which are essential for the well-being and development of our communities. Audits help us hold our leaders and organizations responsible and make sure they're working in our best interests.</p>
    </div>

    <div class="letter-section">
        <h1>Types of Audit Opinions</h1>
        <p>There are four main types of audit opinions issued by SAIs:</p>
        
        <h3>1. Unqualified Opinion (Clean Opinion)</h3>
        <p>This is the most favourable opinion, indicating that the SAI found the financial statements to be presented fairly, in all material respects, in accordance with the applicable financial reporting framework. It signifies that the financial statements are free from material misstatements and provide a true and fair view of the entity's financial position, financial performance, and cash flows.</p>
        
        <h3>2. Qualified Opinion (Modified Opinion)</h3>
        <p>A qualified opinion implies that the SAI encountered limitations during the audit that prevented them from obtaining sufficient appropriate audit evidence to support certain aspects of the financial statements. These limitations might be due to restrictions on the scope of the audit, accounting inconsistencies, or inadequate internal controls. However, the misstatements identified are not considered pervasive or material enough to warrant a disclaimer or adverse opinion. The qualified opinion details the specific area of limitation and its potential impact on the financial statements.</p>
        
        <h3>3. Disclaimer of Opinion</h3>
        <p>In rare cases, the SAI may be unable to express an opinion on the financial statements. This occurs when the limitations on the scope of the audit are so significant that they prevent the SAI from obtaining sufficient appropriate audit evidence to form an opinion on the fairness of the financial statements. The disclaimer of opinion explains the reasons for not expressing an opinion and the potential impact of the limitations.</p>
        
        <h3>4. Adverse Opinion</h3>
        <p>This is the most severe opinion, indicating that the SAI found material misstatements in the financial statements that are pervasive to the extent that they cause the financial statements not to present a fair view, in all material respects, in accordance with the applicable financial reporting framework. The adverse opinion details the nature and extent of the misstatements identified.</p>
    </div>

    <div class="recommendations-details landscape-section">
        <h1>Summary of Recommendations</h1>
        <p>As of <?php echo date('F j, Y'); ?>, there are {{ $recommendationsNotFullyImplemented }} outstanding audit recommendations awaiting full implementation. This figure represents recommendations from {{ $publicationDateRange->start_date }} to {{ $publicationDateRange->end_date }}.</p>
        <p>Analysis of Implementation Status</p>
        <ul>
            <li>Implemented: {{ $fullyImplementedCount }} recommendations have been fully implemented by the audited entities.</li>
            @foreach($recommendationsByStatus as $status)
                @if($status->current_implementation_status == 'Partially Implemented')
                    <li>Partially Implemented: {{ $status->count }} recommendations have seen some progress towards implementation, but require further action.</li>
                @elseif($status->current_implementation_status == 'Not Implemented')
                    <li>Not Implemented: {{ $status->count }} recommendations have not yet been addressed by the audited entities.</li>
                @endif
            @endforeach
            <li>No Update: {{ $NoUpdateCount }} recommendations have seen some progress towards implementation, but require further action.</li>
        </ul>

        <h3>Figure 1: Implementation Status</h3>
        <!-- <h2>Doughnut Chart</h2>
        <img src="{{ $DoughnutChartImageUrl }}" alt="Doughnut Chart">
        
        <h2>Bar Graph</h2>
        <img src="{{ $barChartImageUrl }}" alt="Bar Graph"> -->
        <!-- <img src="{{ $barChartImageUrl }}" alt="Bar Graph"> -->
        <!-- <img src="{{ $DoughnutChartImageUrl }}" alt="Doughnut Chart"> -->

        <img src="{{ $pieChartImageUrl }}" alt="Pie Chart">
        <h1>Table 1: Summary of Audit with Unresolved Recommendations</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>Audit Name</th>
                    <th>Description</th>
                    <th>Publication Date</th>
                    <th>No. of Resolved Recommendations</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($resolvedRecommendations as $recommendation)
                    <tr>
                        <td>{{ $recommendation['audit_report_title'] }}</td>
                        <td>{{ $recommendation['description'] }}</td>
                        <td>{{ $recommendation['publication_date'] }}</td>
                        <td>{{ $recommendation['resolved_recommendations_count'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h1>Table 2: Unresolved Recommendations Details</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>Audited Entity</th>
                    <th>Audit Report Title</th>
                    <th>Publication Date</th>
                    <th>Page Par Reference</th>
                    <th>Audit Recommendation</th>
                    <th>Implementation Status</th>
                    <th>Entity Proposed Completion Date</th>
                    <th>Acceptance Status</th>
                    <th>Actual/Expected Implementation Date</th>
                    <th>Audited Entity Response</th>
                </tr>
            </thead>
            <tbody>
                @foreach($unresolvedRecommendations as $recommendation)
                <tr>
                    <td>{{ $recommendation->audited_entity }}</td>
                    <td>{{ $recommendation->audit_report_title }}</td>
                    <td>{{ $recommendation->publication_date }}</td>
                    <td>{{ $recommendation->page_par_reference }}</td>
                    <td>{{ $recommendation->audit_recommendations }}</td>
                    <td>{{ $recommendation->current_implementation_status }}</td>
                    <td>{{ $recommendation->entity_proposed_completion_date }}</td>
                    <td>{{ $recommendation->acceptance_status }}</td>
                    <td>{{ $recommendation->actual_expected_implementation_date }}</td>
                    <td>{{ $recommendation->audited_entity_response }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="recommendations-details landscape-section">
        <h1>Audit Recommendation Summary - Gender Mainstreaming</h1>
        <p>Gender audits play a pivotal role in ensuring accountability, transparency, and equity within organizations and governments. By systematically assessing policies, programs, and practices through a gender lens, gender audits uncover existing disparities, identify areas for improvement, and promote meaningful change towards gender equality and empowerment. These audits not only assess compliance with gender-related legislation and policies but also highlight the differential impacts of initiatives on various genders. Through their rigorous examination and evidence-based recommendations, gender audits contribute to fostering inclusive environments, advancing women's rights, and ultimately building more equitable societies. In essence, gender audits serve as essential tools for driving progress towards achieving sustainable development goals and promoting social justice.</p>
        
        <p>Economic, physical, and decision-making autonomy are fundamental for women to act as full subjects of development and are essential for achieving gender equality and SDG 5. They are interconnected and should be addressed holistically to promote women's empowerment and ensure the exercise of women's human rights in a context of full equality. Based on the information provided by the CEPAL Gender Observatory, specific criteria for auditing women's autonomy and gender equality can be outlined as follows:</p>
        
        <h3>Economic Autonomy</h3>
        <p>Economic autonomy refers to women's ability to provide for themselves and their dependents by generating their own income and resources through access to paid work under equal conditions with men. It also encompasses the ability to make decisions about resource allocation and access to social security. The care economy, which encompasses unpaid care work and caregiving responsibilities, is closely linked to women's economic autonomy as it often constrains their ability to participate in paid work and decision-making.</p>
        
        <h3>Physical Autonomy</h3>
        <p>Physical autonomy addresses the freedom of women's bodies and their right to make decisions about their own bodies. It encompasses issues related to reproductive rights and gender-based violence. Physical autonomy includes the right to live a life free from violence and the ability to make choices about sexuality and reproductive health. This includes addressing practices such as child, early, and forced marriage, which violate the human rights of children and limit their full development.</p>
        
        <h3>Decision-making Autonomy</h3>
        <p>Decision-making autonomy refers to the presence and equal participation of women and men in decision-making processes at different levels of state power. It involves measures to promote women's full and equal participation in executive and judicial spheres of power. Qualitative indicators are used to monitor progress in this area, including the implementation of conventions ratified by the country, the status of institutional mechanisms for gender equality promotion, and the legal framework for eliminating barriers that limit women's access to decision-making positions.</p>
        <br>
        <h1>The following recommendations have a gender dimension:</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>Audited Entity</th>
                    <th>Audit Report Title</th>
                    <th>Publication Date</th>
                    <th>Page Par Reference</th>
                    <th>Audit Recommendation</th>
                    <th>Mainstreaming Category</th>
                    <th>Implementation Status</th>
                    <th>Entity Proposed Completion Date</th>
                    <th>Acceptance Status</th>
                    <th>Actual/Expected Implementation Date</th>
                    <th>Audited Entity Response</th>
                </tr>
            </thead>
            <tbody>
                @foreach($genderDimensionRecommendations as $recommendation)
                <tr>
                    <td>{{ $recommendation->audited_entity }}</td>
                    <td>{{ $recommendation->audit_report_title }}</td>
                    <td>{{ $recommendation->publication_date }}</td>
                    <td>{{ $recommendation->page_par_reference }}</td>
                    <td>{{ $recommendation->audit_recommendations }}</td>
                    <td>{{ $recommendation->mainstreaming_category }}</td>
                    <td>{{ $recommendation->current_implementation_status }}</td>
                    <td>{{ $recommendation->entity_proposed_completion_date }}</td>
                    <td>{{ $recommendation->acceptance_status }}</td>
                    <td>{{ $recommendation->actual_expected_implementation_date }}</td>
                    <td>{{ $recommendation->audited_entity_response }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    
    <div class="conclusion-section">
        <h1>Conclusion</h1>
        <p>
            The current number of outstanding audit recommendations represents a missed opportunity to significantly improve public sector performance. Unimplemented recommendations can lead to inefficiencies, wasted resources, and potentially, increased risks of fraud or error. The timely implementation of these recommendations is not just about ticking boxes; it's about safeguarding public trust and ensuring that taxpayer dollars are used effectively for the benefit of all citizens.
        </p>
        <p>
            The SAI remains committed to working collaboratively with audited entities. We offer ongoing support and guidance to facilitate the implementation process. However, persistent delays in implementing critical recommendations may necessitate further action, including the escalation of concerns to relevant parliamentary committees or the public.
        </p>
        <p>
            We urge all audited entities to prioritize the implementation of outstanding recommendations. By working together, we can strengthen public accountability and ensure a more efficient and effective public sector that serves the best interests of the nation.
        </p>
    </div>

    <div id="page-footer">
        <div class="page-number"></div>
    </div>

    <!-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            const implementationData = {
                labels: ['Fully Implemented', 'No Update', 'Not Implemented', 'Partially Implemented'],
                datasets: [{
                    data: [20, 30, 15, 10], 
                    backgroundColor: ['#4CAF50', '#FFC107', '#FF5722', '#2196F3'],
                }],
            };

            // Get the chart canvas
            const ctx = document.getElementById('implementation-chart').getContext('2d');

            // Create the Pie Chart
            const implementationChart = new Chart(ctx, {
                type: 'pie',
                data: implementationData,
            });
        });
    </script> -->
</body>
</html>
