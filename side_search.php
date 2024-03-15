<div class="page-sidebar p-15 shadow no_radius" id="filter_links">
<a class="filter_links" data-toggle="collapse" href="#fltbox" role="button" aria-expanded="false" aria-controls="fltbox">Open Advance Filter &nbsp;<i class="fa fa-sliders-h ml-2"></i></a>							
<div class="collapse" id="fltbox">
<!-- Find New Property -->
<div class="sidebar-widgets p-4"> 
    <h4 class="w-100 centered-left">MLS Search</h4>
    <form onsubmit="return false" autocomplete="off">
	<div class="form-group relative quick" data-toggle="tooltip" title="Enter a Community Name, Development, Street, Address or Zip Code">
		<div class="input-with-icon">
			<input type="text" class="form-control" onkeyup="quickSearch(this.value,'lite')" placeholder="Address, Street or Zip Code..." id="advnc_state_or_city" name="advnc_state_or_city" autocomplete="off" />
			<i class="ti-location-pin"></i>
            <img src="assets/img/loader.gif" class="quick_srch_img" />
		</div>
        <ul class="absolute shadow p-0" id="streamed_search" style="top: 50px!important;"></ul>
	</div>
	
    <div class="row">
		<h6 class="col-md-12 centered-text semibold">-OR-</h6>
    </div>
                                
    <div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 pr-5 xs-pr-15">
		<div class="form-group">
			<div class="simple-input" data-toggle="tooltip" title="Property Type">
			    <div class="input-with-icon">
				<select class="form-control" id="advnc_property_type" name="advnc_property_type">
                    <option value="" selected="selected">Select Property Type</option>
                    <option value="Homes">Homes</option>
                    <option value="Condos">Condos</option>
                    <option value="Land">Vacant Land</option>
                    <option value="Commercial">Commercial</option>
                    <option value="Multi-Family">Multi-Family</option>
                    <option value="Town Homes">Town Homes</option>
                    <option value="Dock">Boat Dock</option>
				</select>
                <i class="ti-list-ol"></i>
                </div>
			</div>
		</div> 
        </div>
        
        <div class="col-lg-6 col-md-6 col-sm-6 pl-5 xs-pl-15">
        <div class="form-group">
            <div class="simple-input" data-toggle="tooltip" title="Select City">
        	<div class="input-with-icon">
        		<select class="form-control no_radius" id="advnc_city" name="advnc_city" onchange="reloadComm(this.value)">
                <option value="" selected="selected">Select City</option>
                <option value="Marco Island">Marco Island</option>
                <option value="Naples">Naples</option>
                <option value="Ave Maria">Ave Maria</option>
                <option value="Immokalee">Immokalee</option>
                <option value="Bonita Springs">Bonita Springs</option>
                <option value="Estero">Estero</option>
                <option value="Fort Myers">Fort Myers</option>
                <option value="Cape Coral">Cape Coral</option>
                <option value="Lehigh Acres">Lehigh Acres</option>
                </select>
        		<i class="fas fa-city fs-12"></i>
        	</div>
            </div>
        </div>
        </div>
        
        <div class="col-12">
        <a href="javascript:;" data-toggle="modal" data-target="#MLS_Communities" onclick="loadMLSCityCommunities('Modal');" class="fs-13" style="color: #E67300;">
        <i class="fas fa-city"></i> Click Here To Select Communities
        </a>
        <input type="hidden" id="last_city" name="last_city" value="" />
        </div>
    </div>
    
    <div class="row pt-4">
        <h6 class="col-md-12">Search Criteria</h6>
		<div class="col-lg-6 col-md-6 col-sm-6 pr-5 xs-pr-15">
			<div class="form-group" data-toggle="tooltip" title="Minimum Price">
				<div class="input-with-icon">
					<input type="text" class="form-control" placeholder="Minimum Price" id="advnc_min_price" name="advnc_min_price" />
					<i class="fas fa-dollar-sign"></i>
				</div>
			</div>
		</div>
        
        
		<div class="col-lg-6 col-md-6 col-sm-6 pl-5 xs-pl-15">
			<div class="form-group" data-toggle="tooltip" title="Maximum Price">
				<div class="input-with-icon">
					<input type="text" class="form-control" placeholder="Maximum Price" id="advnc_max_price" name="advnc_max_price" />
					<i class="fas fa-dollar-sign"></i>
				</div>
			</div>
		</div>
    </div> 
	
    <div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 pr-5 xs-pr-15">
			<div class="form-group">
				<div class="simple-input" data-toggle="tooltip" title="Number of Bedroom">
                    <div class="input-with-icon">
					<select id="advnc_beds" name="advnc_beds" class="form-control">
						<option value="Any" selected="">Any # of beds</option>
                        <option value="1">1 Bed</option>
                        <option value="1+">1+ Beds</option>
                        <option value="2+">2+ Beds</option>
                        <option value="3+">3+ Beds</option>
                        <option value="4+">4+ Beds</option>
                        <option value="5+">5+ Beds</option>
                        <option value="6+">6+ Beds</option>
                        <option value="7+">7+ Beds</option>
                        <option value="8+">8+ Beds</option>
                        <option value="9+">9+ Beds</option>
                        <option value="10+">10+ Beds</option>
					</select>
                    <i class="fas fa-bed fs-12"></i>
                    </div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 pl-5 xs-pl-15">
			<div class="form-group" data-toggle="tooltip" title="Number of Bathroom">
				<div class="simple-input">
                    <div class="input-with-icon">
					<select id="advnc_baths" name="advnc_baths" class="form-control">
						<option value="Any" selected="">Any # of baths</option>
                        <option value="1">1 Bath</option>
                        <option value="1+">1+ Baths</option>
                        <option value="2+">2+ Baths</option>
                        <option value="3+">3+ Baths</option>
                        <option value="4+">4+ Baths</option>
                        <option value="5+">5+ Baths</option>
                        <option value="6+">6+ Baths</option>
                        <option value="7+">7+ Baths</option>
                        <option value="8+">8+ Baths</option>
                        <option value="9+">9+ Baths</option>
                        <option value="10+">10+ Baths</option>
					</select>
                    <i class="fas fa-bath"></i>
                    </div>
				</div>
			</div>
		</div>
	</div>
     
    <div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 pr-5 xs-pr-15">
			<div class="form-group">
				<div class="input-with-icon">
					<input type="text" class="form-control" placeholder="Min Area SqFt" id="advnc_min_sq_ft" name="advnc_min_sq_ft" data-toggle="tooltip" title="Minimum Living Area SqFt" />
					<i class="fas fa-ruler-combined"></i>
				</div>
			</div>
		</div>
        
        
		<div class="col-lg-6 col-md-6 col-sm-6 pl-5 xs-pl-15">
			<div class="form-group">
				<div class="input-with-icon">
					<input type="text" class="form-control" placeholder="Max Area SqFt" id="advnc_max_sq_ft" name="advnc_max_sq_ft" data-toggle="tooltip" title="Maximum Living Area SqFt" />
					<i class="fas fa-ruler-combined"></i>
				</div>
			</div>
		</div>
    </div> 
	
	 
    <div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 pr-5 xs-pr-15">
			<div class="form-group">
				<div class="input-with-icon">
					<select class="form-control no_radius" id="advnc_no_garage" name="advnc_no_garage" data-toggle="tooltip" title="Number of Car Garage">
                    <option value="Any" selected="">Any # of garage</option>
                    <option value="1">1</option>
                    <option value="1+">1+</option>
                    <option value="2+">2+</option>
                    <option value="3+">3+</option>
                    <option value="4+">4+</option>
                    <option value="5+">5+</option>
                    <option value="6+">6+</option>
                    <option value="7+">7+</option>
                    <option value="8+">8+</option>
                    <option value="9+">9+</option>
                    <option value="10+">10+</option>
                    </select>
					<i class="fas fa-car"></i>
				</div>
			</div>
		</div>
        
        
		<div class="col-lg-6 col-md-6 col-sm-6 pl-5 xs-pl-15">
			<div class="form-group">
				<div class="input-with-icon">
					<select class="form-control no_radius" id="advnc_min_year" name="advnc_min_year" data-toggle="tooltip" title="Year Built">
                    <option value="Any" selected="">Any year</option>
                    <option value="1990">1990 + </option>
                    <option value="2000">2000 + </option>
                    <option value="2005">2005 + </option>
                    <option value="2010">2010 + </option>
                    <option value="2015">2015 + </option>
                    <option value="2016">2016 + </option>
                    <option value="2017">2017 + </option>
                    <option value="2018">2018 + </option>
                    <option value="2019">2019 + </option>
                    <option value="2020">2020 + </option>
                    <option value="2021">2021 + </option>
                    </select>
					<i class="fas fa-calendar-alt"></i>
				</div>
			</div>
		</div>
    </div> 
    
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 pt-4">
			<h6>More Features</h6>
			<ul class="row p-0 m-0 fs-14">
				<li class="col-lg-6 col-md-6 col-sm-6 p-0">
                    <input id="just_listed" class="checkbox-custom" name="just_listed" type="checkbox" />
    				<label for="just_listed" class="checkbox-custom-label">Just Listed</label>
				</li>
				<li class="col-lg-6 col-md-6 col-sm-6 p-0">
                    <input id="include_sold" class="checkbox-custom" name="include_sold" type="checkbox" />
    				<label for="include_sold" class="checkbox-custom-label">Include Sold</label>
				</li>
				<li class="col-lg-6 col-md-6 col-sm-6 p-0">
                    <input id="foreclosure" class="checkbox-custom" name="foreclosure" type="checkbox" />
    				<label for="foreclosure" class="checkbox-custom-label">Foreclosure</label>
				</li>
				<li class="col-lg-6 col-md-6 col-sm-6 p-0">
                    <input id="short_sale" class="checkbox-custom" name="short_sale" type="checkbox" />
    				<label for="short_sale" class="checkbox-custom-label">Short Sale</label>
				</li>
				<li class="col-lg-6 col-md-6 col-sm-6 p-0">
                    <input id="pool" class="checkbox-custom" name="pool" type="checkbox" />
    				<label for="pool" class="checkbox-custom-label">Pool</label>
				</li>
				<li class="col-lg-6 col-md-6 col-sm-6 p-0">
                    <input id="spa" class="checkbox-custom" name="spa" type="checkbox" />
    				<label for="spa" class="checkbox-custom-label">Spa</label>
				</li>
				<li class="col-lg-6 col-md-6 col-sm-6 p-0">
                    <input id="guest_house" class="checkbox-custom" name="guest_house" type="checkbox" />
    				<label for="guest_house" class="checkbox-custom-label">Guest House</label>
				</li>
				<li class="col-lg-6 col-md-6 col-sm-6 p-0">
                    <input id="waterfront" class="checkbox-custom" name="waterfront" type="checkbox" />
    				<label for="waterfront" class="checkbox-custom-label">Waterfront</label>
				</li>
                <li class="col-lg-6 col-md-6 col-sm-6 p-0">
                    <input id="gated" class="checkbox-custom" name="gated" type="checkbox" />
    				<label for="gated" class="checkbox-custom-label">Gated Community</label>
				</li>
                <li class="col-lg-6 col-md-6 col-sm-6 p-0">
                    <input id="gulf_access" class="checkbox-custom" name="gulf_access" type="checkbox" />
    				<label for="gulf_access" class="checkbox-custom-label">Gulf Access</label>
				</li>
			</ul>
		</div>
	</div>
	
    <div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 pt-4">
			<h6>MLS Number</h6>
            <div class="form-group" data-toggle="tooltip" title="MLS Number">
				<div class="input-with-icon">
					<input type="text" class="form-control" placeholder="MLS Number" id="advnc_mls_number" name="advnc_mls_number" autocomplete="off" />
					<i class="fas fa-server"></i>
				</div>
			</div>
        </div>
    </div>
    </form>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 pt-4">
			<button class="btn theme-bg rounded full-width" onclick="AdvanceSearch('Side')"><i class="ti-search"></i> Search</button>
		</div>
	</div>
    <input type="hidden" id="serch_ref" name="serch_ref" value="quick" />
</div>
</div>
</div>


<div id="mob_srch_fxd_flter">
<a data-toggle="collapse" href="#fltbox" style="color: white;" role="button" aria-expanded="false" aria-controls="fltbox" onclick="scrollToDiv('filter_links', '150')">
<i class="fa fa-sliders-h ml-2"></i>
</a>
</div>