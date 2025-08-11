<?php
// resources/views/public/about.blade.php
?>
@extends('layouts.app')

@section('title', 'Tentang DEVO - Dashboard Monitoring Depo Sampah')

@section('content')
<div class="container">
    <!-- Enhanced Hero Section -->
    <div class="about-hero mb-5" data-aos="fade-down">
        <div class="hero-content text-center">
            <div class="hero-logo">
                <i class="fas fa-recycle"></i>
            </div>
            <h1 class="hero-title heading-font">DEVO</h1>
            <p class="hero-subtitle">Dashboard Monitoring Volume Sampah Depo Real-time</p>
            <div class="hero-badges">
                <span class="hero-badge">
                    <i class="fas fa-wifi me-2"></i>Real-time Monitoring
                </span>
                <span class="hero-badge">
                    <i class="fas fa-chart-line me-2"></i>Smart Analytics
                </span>
                <span class="hero-badge">
                    <i class="fas fa-bell me-2"></i>Auto Notifications
                </span>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <!-- About System Section -->
            <div class="about-card mb-5" data-aos="fade-up" data-aos-delay="100">
                <div class="about-card-header">
                    <div class="section-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="section-title">
                        <h3>Tentang Sistem</h3>
                        <p>Inovasi teknologi untuk pengelolaan sampah yang lebih cerdas</p>
                    </div>
                </div>
                <div class="about-card-body">
                    <div class="description-text">
                        <p>
                            <strong>DEVO (Dashboard Monitoring Depo Sampah)</strong> adalah sistem monitoring volume sampah real-time 
                            yang dirancang untuk pengelolaan sampah yang lebih efektif dan efisien. Sistem ini 
                            menggunakan teknologi sensor ultrasonik HC-SR04 dan mikrokontroler ESP32 untuk 
                            memantau tingkat kepenuhan depo sampah secara otomatis.
                        </p>
                    </div>
                    
                    <div class="features-grid">
                        <h4 class="features-title">Fitur Unggulan Sistem:</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="feature-group">
                                    <h6><i class="fas fa-desktop me-2"></i>Dashboard & Monitoring</h6>
                                    <ul class="feature-list">
                                        <li><i class="fas fa-check"></i>Monitoring volume real-time</li>
                                        <li><i class="fas fa-check"></i>Dashboard publik untuk masyarakat</li>
                                        <li><i class="fas fa-check"></i>Dashboard admin untuk pengelolaan</li>
                                        <li><i class="fas fa-check"></i>Grafik historical data</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="feature-group">
                                    <h6><i class="fas fa-cogs me-2"></i>Automasi & Notifikasi</h6>
                                    <ul class="feature-list">
                                        <li><i class="fas fa-check"></i>Notifikasi otomatis saat depo penuh</li>
                                        <li><i class="fas fa-check"></i>Sistem pelaporan permasalahan anonim</li>
                                        <li><i class="fas fa-check"></i>Status LED indicator</li>
                                        <li><i class="fas fa-check"></i>Estimasi waktu penuh</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Technology Stack Section -->
            <div class="tech-section mb-5" data-aos="fade-up" data-aos-delay="200">
                <div class="section-header text-center mb-5">
                    <h3 class="heading-font">Teknologi yang Digunakan</h3>
                    <p class="text-muted">Stack teknologi modern untuk performa optimal</p>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="tech-card" data-aos="zoom-in" data-aos-delay="300">
                            <div class="tech-icon">
                                <i class="fas fa-microchip"></i>
                            </div>
                            <h5>Hardware IoT</h5>
                            <div class="tech-list">
                                <span class="tech-item">Sensor HC-SR04</span>
                                <span class="tech-item">ESP32 Microcontroller</span>
                                <span class="tech-item">LED Indicators</span>
                                <span class="tech-item">WiFi Connectivity</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="tech-card" data-aos="zoom-in" data-aos-delay="400">
                            <div class="tech-icon">
                                <i class="fab fa-laravel"></i>
                            </div>
                            <h5>Backend System</h5>
                            <div class="tech-list">
                                <span class="tech-item">Laravel Framework</span>
                                <span class="tech-item">MySQL Database</span>
                                <span class="tech-item">Pusher WebSocket</span>
                                <span class="tech-item">RESTful API</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="tech-card" data-aos="zoom-in" data-aos-delay="500">
                            <div class="tech-icon">
                                <i class="fab fa-js-square"></i>
                            </div>
                            <h5>Frontend UI/UX</h5>
                            <div class="tech-list">
                                <span class="tech-item">CSS Framework</span>
                                <span class="tech-item">Javascript Libraries</span>
                                <span class="tech-item">Design Concept Used</span>
                                <span class="tech-item">Color Schema/span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- How It Works Section -->
            <div class="workflow-section mb-5" data-aos="fade-up" data-aos-delay="300">
                <div class="workflow-header text-center mb-5">
                    <h3 class="heading-font">Cara Kerja Sistem</h3>
                    <p class="text-muted">Proses monitoring otomatis dari sensor hingga notifikasi</p>
                </div>
                <div class="workflow-steps">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="workflow-step" data-aos="fade-up" data-aos-delay="400">
                                <div class="step-number">
                                    <span>1</span>
                                </div>
                                <div class="step-icon">
                                    <i class="fas fa-ruler"></i>
                                </div>
                                <h5>Pengukuran</h5>
                                <p>Sensor HC-SR04 mengukur jarak dari langit-langit ke permukaan sampah secara akurat</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="workflow-step" data-aos="fade-up" data-aos-delay="500">
                                <div class="step-number">
                                    <span>2</span>
                                </div>
                                <div class="step-icon">
                                    <i class="fas fa-wifi"></i>
                                </div>
                                <h5>Transmisi Data</h5>
                                <p>ESP32 mengirim data ke server melalui WiFi secara real-time setiap 30 menit</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="workflow-step" data-aos="fade-up" data-aos-delay="600">
                                <div class="step-number">
                                    <span>3</span>
                                </div>
                                <div class="step-icon">
                                    <i class="fas fa-calculator"></i>
                                </div>
                                <h5>Perhitungan</h5>
                                <p>Server menghitung volume, persentase kepenuhan, dan estimasi waktu penuh</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="workflow-step" data-aos="fade-up" data-aos-delay="700">
                                <div class="step-number">
                                    <span>4</span>
                                </div>
                                <div class="step-icon">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <h5>Notifikasi Otomatis</h5>
                                <p>Sistem memberikan notifikasi real-time dan update dashboard secara otomatis</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Status Indicators Section -->
            <div class="status-section mb-5" data-aos="fade-up" data-aos-delay="400">
                <div class="status-header text-center mb-5">
                    <h3 class="heading-font">Indikator Status Depo</h3>
                    <p class="text-muted">Sistem klasifikasi status berdasarkan tingkat kepenuhan</p>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <div class="status-card normal" data-aos="flip-left" data-aos-delay="500">
                            <div class="status-indicator">
                                <div class="status-circle normal-status"></div>
                                <div class="status-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="status-content">
                                <h5>Normal (0-79%)</h5>
                                <p>Depo dalam kondisi aman dengan kapasitas tersedia. Pengangkutan rutin sesuai jadwal.</p>
                                <div class="status-features">
                                    <span><i class="fas fa-check"></i> LED Off</span>
                                    <span><i class="fas fa-check"></i> Kapasitas Aman</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="status-card warning" data-aos="flip-left" data-aos-delay="600">
                            <div class="status-indicator">
                                <div class="status-circle warning-status"></div>
                                <div class="status-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                            </div>
                            <div class="status-content">
                                <h5>Warning (80-90%)</h5>
                                <p>Depo hampir penuh dan memerlukan perhatian khusus. Perlu dijadwalkan pengangkutan.</p>
                                <div class="status-features">
                                    <span><i class="fas fa-exclamation"></i> LED Berkedip</span>
                                    <span><i class="fas fa-exclamation"></i> Perlu Perhatian</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="status-card critical" data-aos="flip-left" data-aos-delay="700">
                            <div class="status-indicator">
                                <div class="status-circle critical-status"></div>
                                <div class="status-icon">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                            </div>
                            <div class="status-content">
                                <h5>Critical (>90%)</h5>
                                <p>Depo penuh dan memerlukan tindakan segera. LED menyala merah, pengangkutan darurat diperlukan.</p>
                                <div class="status-features">
                                    <span><i class="fas fa-times"></i> LED Menyala</span>
                                    <span><i class="fas fa-times"></i> Tindakan Darurat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Section -->
            <div class="contact-section" data-aos="fade-up" data-aos-delay="600">
                <div class="contact-card">
                    <div class="contact-header text-center">
                        <div class="contact-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3>Kontak & Support</h3>
                        <p>Untuk pertanyaan, saran, atau dukungan teknis sistem DEVO</p>
                    </div>
                    <div class="contact-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="contact-item" data-aos="fade-up" data-aos-delay="700">
                                    <div class="contact-item-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="contact-item-content">
                                        <h6>Email Support</h6>
                                        <p>cs@lifemedia.id</p>
                                        <small>Response time: 24 hours</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="contact-item" data-aos="fade-up" data-aos-delay="800">
                                    <div class="contact-item-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="contact-item-content">
                                        <h6>Hotline 24/7</h6>
                                        <p>(+62) 2746055655</p>
                                        <small>Emergency support available</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="contact-item" data-aos="fade-up" data-aos-delay="900">
                                    <div class="contact-item-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="contact-item-content">
                                        <h6>Headquarters</h6>
                                        <p>Jl. Parangtritis No.97, Brontokusuman, Kec. Mergangsan</p>
                                        <small>Kota Yogyakarta, Daerah Istimewa Yogyakarta 55153</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Enhanced Hero Section */
    .about-hero {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
    }

    .about-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
    }

    .hero-logo {
        width: 120px;
        height: 120px;
        background: var(--primary-gradient);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        margin: 0 auto 2rem auto;
        animation: heroFloat 3s ease-in-out infinite;
    }

    @keyframes heroFloat {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .hero-title {
        font-size: 4rem;
        font-weight: 900;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1rem;
        letter-spacing: 2px;
    }

    .hero-subtitle {
        font-size: 1.5rem;
        color: #6b7280;
        margin-bottom: 2rem;
        font-weight: 500;
    }

    .hero-badges {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .hero-badge {
        background: rgba(102, 126, 234, 0.1);
        color: var(--primary-color);
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
        border: 1px solid rgba(102, 126, 234, 0.2);
    }

    /* About Card */
    .about-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
    }

    .about-card-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .section-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        flex-shrink: 0;
    }

    .section-title h3 {
        margin: 0;
        font-weight: 700;
        font-size: 2rem;
    }

    .section-title p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
    }

    .about-card-body {
        padding: 2.5rem;
    }

    .description-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #374151;
        margin-bottom: 2rem;
    }

    .features-title {
        color: var(--dark-color);
        margin-bottom: 2rem;
        font-weight: 700;
    }

    .feature-group {
        margin-bottom: 2rem;
    }

    .feature-group h6 {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .feature-list {
        list-style: none;
        padding: 0;
    }

    .feature-list li {
        padding: 0.5rem 0;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .feature-list li i {
        color: var(--success-color);
        font-size: 0.9rem;
    }

    /* Technology Cards */
    .section-header h3 {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 1rem;
    }

    .tech-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        padding: 2.5rem 2rem;
        text-align: center;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: var(--transition);
        height: 100%;
    }

    .tech-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
    }

    .tech-icon {
        width: 100px;
        height: 100px;
        background: var(--primary-gradient);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin: 0 auto 1.5rem auto;
    }

    .tech-card h5 {
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 1.5rem;
        font-size: 1.3rem;
    }

    .tech-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .tech-item {
        background: rgba(102, 126, 234, 0.1);
        color: var(--primary-color);
        padding: 0.75rem 1rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        font-size: 0.9rem;
        border: 1px solid rgba(102, 126, 234, 0.2);
    }

    /* Workflow Steps */
    .workflow-header h3 {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 1rem;
    }

    .workflow-step {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        text-align: center;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        transition: var(--transition);
        height: 100%;
    }

    .workflow-step:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
    }

    .step-number {
        position: absolute;
        top: -20px;
        left: 50%;
        transform: translateX(-50%);
        width: 40px;
        height: 40px;
        background: var(--primary-gradient);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .step-icon {
        width: 80px;
        height: 80px;
        background: rgba(102, 126, 234, 0.1);
        color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 1rem auto 1.5rem auto;
    }

    .workflow-step h5 {
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 1rem;
    }

    .workflow-step p {
        color: #6b7280;
        line-height: 1.6;
    }

    /* Status Cards */
    .status-header h3 {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 1rem;
    }

    .status-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: var(--transition);
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .status-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .status-card.normal::before { background: var(--success-gradient); }
    .status-card.warning::before { background: var(--warning-gradient); }
    .status-card.critical::before { background: var(--danger-gradient); }

    .status-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
    }

    .status-indicator {
        position: relative;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .status-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto;
        position: relative;
    }

    .normal-status { background: var(--success-gradient); }
    .warning-status { background: var(--warning-gradient); }
    .critical-status { background: var(--danger-gradient); }

    .status-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 2rem;
    }

    .status-content h5 {
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 1rem;
        font-size: 1.3rem;
    }

    .status-content p {
        color: #6b7280;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .status-features {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .status-features span {
        font-size: 0.9rem;
        font-weight: 600;
        color: #374151;
    }

    .status-features i {
        margin-right: 0.5rem;
        width: 16px;
    }

    /* Developers Section */
    .developers-header h3 {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 1rem;
    }

    .developer-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: var(--transition);
        height: 100%;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .developer-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
    }

    .developer-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
    }

    .developer-avatar {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .avatar-placeholder {
        width: 120px;
        height: 120px;
        background: var(--primary-gradient);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin: 0 auto;
        position: relative;
    }

    .developer-role {
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--success-gradient);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .developer-info h5 {
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
        font-size: 1.4rem;
    }

    .developer-title {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .developer-skills {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .skill-tag {
        background: rgba(102, 126, 234, 0.1);
        color: var(--primary-color);
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        border: 1px solid rgba(102, 126, 234, 0.2);
    }

    .developer-desc {
        color: #6b7280;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    /* Contact Section */
    .contact-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
    }

    .contact-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 2rem;
    }

    .contact-icon {
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin: 0 auto 1.5rem auto;
    }

    .contact-header h3 {
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .contact-body {
        padding: 2.5rem;
    }

    .contact-item {
        background: rgba(255, 255, 255, 0.8);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        text-align: center;
        transition: var(--transition);
        border: 1px solid rgba(255, 255, 255, 0.3);
        height: 100%;
    }

    .contact-item:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        background: rgba(255, 255, 255, 0.95);
    }

    .contact-item-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-gradient);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 1rem auto;
    }

    .contact-item h6 {
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
    }

    .contact-item p {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .contact-item small {
        color: #6b7280;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-badges {
            flex-direction: column;
            align-items: center;
        }

        .about-card-header {
            flex-direction: column;
            text-align: center;
        }

        .section-title h3 {
            font-size: 1.5rem;
        }

        .section-header h3,
        .workflow-header h3,
        .status-header h3,
        .developers-header h3 {
            font-size: 2rem;
        }

        .developer-skills {
            justify-content: center;
        }
    }

    /* Animations */
    .fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 100
    });

    // Add scroll animations
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.about-hero');
        
        if (hero) {
            const speed = scrolled * 0.5;
            hero.style.transform = `translateY(${speed}px)`;
        }
    });

    // Add hover effects to cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.tech-card, .workflow-step, .status-card, .developer-card, .contact-item');
        
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Add staggered animation to feature lists
        const featureItems = document.querySelectorAll('.feature-list li');
        featureItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-20px)';
            setTimeout(() => {
                item.style.transition = 'all 0.5s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, index * 100);
        });
    });
</script>
@endpush
@endsection