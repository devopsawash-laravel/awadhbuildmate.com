@extends('layouts.app')

@section('title', 'Payroll Management')

@section('page-title', 'Payroll Management')

@section('content')

<style>

.payroll-wrapper{
    margin-top:40px;
    display:flex;
    justify-content:center;
}

.payroll-grid{
    width:100%;
    max-width:1100px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(420px,1fr));
    gap:30px;
}

.payroll-card{
    position:relative;
    overflow:hidden;
    border-radius:30px;
    padding:40px 35px;
    min-height:300px;
    text-decoration:none;
    color:#fff;
    transition:0.35s ease;
    animation:floatCard 4s ease-in-out infinite;
    backdrop-filter:blur(10px);
}

.payroll-card:hover{
    transform:translateY(-10px) scale(1.01);
}

.labour-card{
    background:linear-gradient(135deg,#ea580c 0%,#fb923c 100%);
    box-shadow:0 18px 45px rgba(234,88,12,0.22);
}

.staff-card{
    background:linear-gradient(135deg,#1e3a8a 0%,#2563eb 100%);
    box-shadow:0 18px 45px rgba(37,99,235,0.20);
}

.payroll-card::before{
    content:'';
    position:absolute;
    width:260px;
    height:260px;
    border-radius:50%;
    background:rgba(255,255,255,0.08);
    top:-120px;
    right:-100px;
    animation:circleMove 6s ease-in-out infinite;
}

.payroll-card::after{
    content:'';
    position:absolute;
    width:180px;
    height:180px;
    border-radius:50%;
    background:rgba(255,255,255,0.06);
    bottom:-80px;
    left:-60px;
    animation:circleMove2 7s ease-in-out infinite;
}

.payroll-icon{
    width:78px;
    height:78px;
    border-radius:22px;
    background:rgba(255,255,255,0.14);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:34px;
    margin-bottom:28px;
    backdrop-filter:blur(8px);
    animation:pulseIcon 2.5s infinite;
}

.payroll-title{
    font-size:32px;
    font-weight:700;
    margin-bottom:12px;
    letter-spacing:0.3px;
}

.payroll-desc{
    font-size:15px;
    line-height:1.9;
    color:rgba(255,255,255,0.88);
    max-width:420px;
}

.payroll-footer{
    margin-top:35px;
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.payroll-open{
    font-size:15px;
    font-weight:600;
    letter-spacing:0.3px;
}

.payroll-arrow{
    width:50px;
    height:50px;
    border-radius:16px;
    background:rgba(255,255,255,0.15);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
    transition:0.3s ease;
}

.payroll-card:hover .payroll-arrow{
    transform:translateX(6px);
}

@keyframes floatCard{

    0%{
        transform:translateY(0px);
    }

    50%{
        transform:translateY(-4px);
    }

    100%{
        transform:translateY(0px);
    }
}

@keyframes pulseIcon{

    0%{
        transform:scale(1);
    }

    50%{
        transform:scale(1.08);
    }

    100%{
        transform:scale(1);
    }
}

@keyframes circleMove{

    0%{
        transform:translateY(0px) rotate(0deg);
    }

    50%{
        transform:translateY(15px) rotate(10deg);
    }

    100%{
        transform:translateY(0px) rotate(0deg);
    }
}

@keyframes circleMove2{

    0%{
        transform:translateX(0px);
    }

    50%{
        transform:translateX(12px);
    }

    100%{
        transform:translateX(0px);
    }
}

@media(max-width:768px){

    .payroll-grid{
        grid-template-columns:1fr;
    }

    .payroll-card{
        min-height:auto;
    }

    .payroll-title{
        font-size:26px;
    }
}

</style>

<div class="page-header">

    <div>

        <div class="page-title">
            Payroll Management
        </div>

        <div class="page-subtitle">
            Manage labour and staff payroll operations from a centralized system
        </div>

    </div>

</div>

<div class="payroll-wrapper">

    <div class="payroll-grid">

        {{-- Labour Payroll --}}
        <a href="{{ route('salary.index') }}"
           class="payroll-card labour-card">

            <div>

                <div class="payroll-icon">

                    <i class="fas fa-hard-hat"></i>

                </div>

                <div class="payroll-title">

                    Labour Payroll

                </div>

                <div class="payroll-desc">

                    Handle attendance-based salary generation,
                    overtime calculations, deductions,
                    advances and printable labour payslips.

                </div>

            </div>

            <div class="payroll-footer">

                <div class="payroll-open">

                    Open Labour Module

                </div>

                <div class="payroll-arrow">

                    <i class="fas fa-arrow-right"></i>

                </div>

            </div>

        </a>

        {{-- Staff Payroll --}}
        <a href="{{ route('staff-salary.index') }}"
           class="payroll-card staff-card">

            <div>

                <div class="payroll-icon">

                    <i class="fas fa-user-tie"></i>

                </div>

                <div class="payroll-title">

                    Staff Payroll

                </div>

                <div class="payroll-desc">

                    Manage fixed salary structures,
                    allowances, payroll reports,
                    deductions and printable staff salary slips.

                </div>

            </div>

            <div class="payroll-footer">

                <div class="payroll-open">

                    Open Staff Module

                </div>

                <div class="payroll-arrow">

                    <i class="fas fa-arrow-right"></i>

                </div>

            </div>

        </a>

    </div>

</div>

@endsection