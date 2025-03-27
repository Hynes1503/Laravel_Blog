<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_AnalyticsReporting;
use Google_Service_AnalyticsReporting_DateRange;
use Google_Service_AnalyticsReporting_Metric;
use Google_Service_AnalyticsReporting_Dimension;
use Google_Service_AnalyticsReporting_ReportRequest;

class AnalyticsController extends Controller
{
    public function getAnalytics()
    {
        // Khởi tạo Google Client
        $client = new Google_Client();
        $client->setApplicationName("Laravel Analytics");
        $client->setAuthConfig(storage_path('credentials.json')); // Đường dẫn đến file JSON
        $client->addScope(Google_Service_AnalyticsReporting::ANALYTICS_READONLY);

        // Khởi tạo dịch vụ Analytics
        $analytics = new Google_Service_AnalyticsReporting($client);

        // Thiết lập tham số truy vấn
        $viewId = "ga:YOUR_VIEW_ID"; // Thay bằng View ID của bạn
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate("7daysAgo");
        $dateRange->setEndDate("today");

        // Metrics (ví dụ: số phiên)
        $sessions = new Google_Service_AnalyticsReporting_Metric();
        $sessions->setExpression("ga:sessions");
        $sessions->setAlias("sessions");

        // Dimensions (ví dụ: theo ngày)
        $date = new Google_Service_AnalyticsReporting_Dimension();
        $date->setName("ga:date");

        // Tạo yêu cầu báo cáo
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($viewId);
        $request->setDateRanges($dateRange);
        $request->setMetrics([$sessions]);
        $request->setDimensions([$date]);

        // Gửi yêu cầu và lấy phản hồi
        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests([$request]);
        $response = $analytics->reports->batchGet($body);

        // Xử lý dữ liệu trả về
        $data = [];
        foreach ($response->getReports() as $report) {
            $rows = $report->getData()->getRows();
            foreach ($rows as $row) {
                $data[] = [
                    'date' => $row->getDimensions()[0],
                    'sessions' => $row->getMetrics()[0]->getValues()[0],
                ];
            }
        }

        // Trả về view hoặc JSON
        return view('analytics', ['data' => $data]);
    }
}